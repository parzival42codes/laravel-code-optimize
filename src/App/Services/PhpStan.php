<?php

namespace parzival42codes\LaravelCodeOptimize\App\Services;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;

class PhpStan
{
    public function dispatch(): Renderable
    {
        $path = '/tmp/phpstan.json';

        $phpStanJson = [
            'totals' => [],
            'files' => [],
            'errors' => 0,
        ];

        $storageDisk = Storage::disk('storage');
        if ($storageDisk->exists($path)) {
            $phpStanContent = $storageDisk->get($path);
            if ($phpStanContent) {
                $phpStanJsonDecode = json_decode($phpStanContent, true);

                if (! json_last_error()) {
                    $phpStanJson = $phpStanJsonDecode;
                }
            }
        }

        return View::make('code-optimize::phpstan', compact([
            'phpStanJson',
        ]));
    }
}
