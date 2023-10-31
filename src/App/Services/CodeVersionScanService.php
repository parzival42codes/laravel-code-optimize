<?php

namespace parzival42codes\LaravelCodeVersion\App\Services;

use ReflectionClass;
use ReflectionException;
use Spatie\StructureDiscoverer\Discover;

class CodeVersionScanService
{
    private array $codeInfoCollection = [];

    /**
     * @throws ReflectionException
     */
    public function __construct(array $versions, array $configPaths)
    {
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
                        $codeInfo['version'][$matchVersion[0]] = $matchVersion[1].' / '.$versionToCompare;
                        $codeInfo['versionCompare'][$matchVersion[0]] = version_compare(
                            $versionCurrent,
                            $versionToCompare
                        );
                        $codeInfo['versionDoc'] = true;

                        $this->codeInfoCollection[$discover] = $codeInfo;

                    }
                } else {
                    $codeInfo['note'] = null;
                    $codeInfo['version'] = [];
                    $codeInfo['versionDoc'] = false;
                    $codeInfo['discover'] = $discover;
                    $this->codeInfoCollection[$discover] = $codeInfo;
                }
            }
        }
    }

    public function getArray(): array
    {
        return $this->codeInfoCollection;
    }
}
