<?php

namespace parzival42codes\LaravelCodeOptimize\App\Services;

use Illuminate\Contracts\Support\Renderable;
use ReflectionException;
use Storage;
use View;

class EnlightnService
{
    /**
     * @throws ReflectionException
     */
    public function dispatch(): Renderable
    {
        $path = '/tmp/enlightn.txt';

        $enlightnTable = [];

        $storageDisk = Storage::disk('storage');
        if ($storageDisk->exists($path)) {
            $contentFile = $storageDisk->get($path);

            if ($contentFile) {
                preg_match_all('!Check (.*?)(?=Check|\.html)!si', $contentFile, $matches, PREG_SET_ORDER);

                foreach ($matches as $matchKey => $match) {
                    $message = trim($match[1]);

                    $enlightnTable[$matchKey]['status'] = '';

                    if (str_contains($match[0], 'Passed')) {
                        $enlightnTable[$matchKey]['status'] = 'Passed';
                    }
                    if (str_contains($match[0], 'Not Applicable')) {
                        $enlightnTable[$matchKey]['status'] = 'Not Applicable';
                    }
                    if (str_contains($match[0], 'Failed')) {
                        $enlightnTable[$matchKey]['status'] = 'Failed';
                    }
                    if (str_contains($match[0], 'Exception')) {
                        $enlightnTable[$matchKey]['status'] = 'Exception';
                    }

                    if (str_contains($match[0], 'Documentation URL:')) {
                        $message = preg_replace('!Documentation URL:(.*)!si',
                            'Documentation URL: <a href="${1}.html" target="_blank">${1}.html</a>', $message);
                    }

                    if ($message) {
                        $enlightnTable[$matchKey]['message'] = strtr($message, [
                            'Not Applicable' => '',
                            'Passed' => '',
                            'Failed' => '',
                            'Exception' => '',
                        ]);
                    }
                }
            }
        }

        return View::make('code-optimize::enlightn', compact([
            'enlightnTable',
        ]));
    }
}
