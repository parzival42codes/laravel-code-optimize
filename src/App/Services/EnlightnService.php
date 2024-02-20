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
                preg_match_all('!Check (.*?)\n!si', $contentFile, $matches, PREG_SET_ORDER);

                foreach ($matches as $matchKey => $match) {
                    $enlightnTable[$matchKey] = [
                        'message' => ($match[1] ?? ''),
                    ];

                    $enlightnTable[$matchKey]['status'] = '';
                    if (str_contains($match[0], 'Not Applicable')) {
                        $enlightnTable[$matchKey]['status'] = 'Not Applicable';
                    } elseif (str_contains($match[0], 'Passed')) {
                        $enlightnTable[$matchKey]['status'] = 'Passed';
                    }
                    if (str_contains($match[0], 'Failed')) {
                        $enlightnTable[$matchKey]['status'] = 'Failed';
                    }
                }
            }
        }

        return View::make('code-optimize::enlightn', compact([
            'enlightnTable',
        ]));
    }
}
