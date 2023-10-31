<?php

namespace parzival42codes\LaravelCodeOptimize\App\Services;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;

class PhpMd
{
    public function dispatch(): Renderable
    {
        $path = '/tmp/phpmd.json';

        $phpMdJson = [
            'files' => [],
        ];

        $phpMdStats = [
            'files' => 0,
            'entries' => 0,
        ];

        $storageDisk = Storage::disk('storage');
        if ($storageDisk->exists($path)) {
            $storageDiskContent = $storageDisk->get($path);
            if ($storageDiskContent) {
                /** @var array $phpMdJson */
                $phpMdJson = json_decode($storageDiskContent, true);
            }
        }

        if ($phpMdJson) {
            $phpMdStats['files'] = count($phpMdJson['files']);
        }

        if (isset($phpMdJson['files'])) {
            foreach ($phpMdJson['files'] as $file) {
                $phpMdStats['entries'] += count($file['violations']);
            }
        }

        return View::make('code-optimize::phpmd', compact([
            'phpMdJson',
            'phpMdStats',
        ]));
    }
}
