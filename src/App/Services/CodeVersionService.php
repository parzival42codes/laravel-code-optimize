<?php

namespace parzival42codes\LaravelCodeOptimize\App\Services;

use Illuminate\Contracts\Support\Renderable;
use ReflectionClass;
use Spatie\StructureDiscoverer\Discover;

class CodeVersionService
{
    public function dispatch(): Renderable
    {
        $codeData = [];

        /** @var array $versions */
        $versions = config('code-version.versions_required');
        /** @var array $configPaths */
        $configPaths = config('code-version.scan_path');

        $versionsTD = count($versions) * 3;

        foreach ($configPaths as $configPath) {
            $discoverClass = Discover::in($configPath)->classes()->get();
            /** @var string $discover */
            foreach ($discoverClass as $discover) {
                $reflectionClass = new ReflectionClass($discover);

                $docComment = $reflectionClass->getDocComment();

                if ($docComment) {
                    $codeInfo = [
                        'discover' => $discover,
                        'versionDoc' => false,
                        'version' => [],
                        'note' => null,
                    ];

                    preg_match_all('!@code-version (.*)!i', $docComment, $matches, PREG_SET_ORDER);

                    foreach ($matches as $match) {
                        $matchVersion = explode(' ', $match[1]);

                        $versionCurrent = $versions[$matchVersion[0]] ?? '1.0.0';
                        $versionToCompare = $matchVersion[1] ?? '';

                        $codeInfo['note'][$matchVersion[0]] = $matchVersion[2] ?? '';
                        $codeInfo['version'][$matchVersion[0]] = $versionToCompare.' / '.$versionCurrent;
                        $codeInfo['versionCompare'][$matchVersion[0]] = version_compare(
                            $versionToCompare,
                            $versionCurrent
                        );
                        $codeInfo['versionDoc'] = true;

                        $codeData[$discover] = $codeInfo;
                    }
                } else {
                    $codeInfo['note'] = null;
                    $codeInfo['version'] = [];
                    $codeInfo['versionDoc'] = false;
                    $codeInfo['discover'] = $discover;
                    $codeData[$discover] = $codeInfo;
                }
            }
        }

        return view('code-optimize::codeversion', compact([
            'codeData',
            'versions',
            'versionsTD',
        ]));
    }
}
