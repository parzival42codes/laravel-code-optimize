<?php

namespace parzival42codes\LaravelCodeOptimize\App\Services;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;

class Leasot
{
    public function dispatch(): Renderable
    {
        $path = '/tmp/leasot.json';

        $leasotTags = [
            'FIXME' => [],
            'TODO' => [],
        ];

        $storageDisk = Storage::disk('storage');
        if ($storageDisk->exists($path)) {
            $leasotContent = $storageDisk->get($path);
            if ($leasotContent) {
                /** @var array $leasotJson */
                $leasotJson = json_decode($leasotContent, true);

                if (! json_last_error()) {
                    foreach ($leasotJson as $item) {
                        $leasotTags[$item['tag']][$item['ref']][] = $item;
                    }
                }
            }
        }

        return View::make('code-optimize::leasot', compact([
            'leasotTags',
        ]));
    }
}
