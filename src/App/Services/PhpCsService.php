<?php

namespace parzival42codes\LaravelCodeOptimize\App\Services;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;

class PhpCsService
{
    public function dispatch(): Renderable
    {
        $path = '/tmp/phpcs.json';

        $phpcs = [
            'totals' => [
                'errors' => 0,
                'warnings' => 0,
                'fixable' => 0,
            ],
            'files' => [],
        ];

        $storageDisk = Storage::disk('storage');
        if ($storageDisk->exists($path)) {
            $storageDiskContent = $storageDisk->get($path);
            if ($storageDiskContent) {
                /** @var array $phpMdJson */
                $phpcs = json_decode($storageDiskContent, true);
            }
        }

        //        d($phpcs);
        //        exit();

        return View::make('code-optimize::phpcs', compact([
            'phpcs',
        ]));
    }
}
