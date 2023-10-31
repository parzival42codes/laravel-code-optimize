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

        $storageDisk = Storage::disk('storage');
        if ($storageDisk->exists($path)) {
            $storageDiskContent = $storageDisk->get($path);
            if ($storageDiskContent) {
                /** @var array $phpMdJson */
                $phpCsJson = json_decode($storageDiskContent, true);

                d($phpCsJson);
            }
        }

        return View::make('code-optimize::phpcs', compact([

        ]));
    }
}
