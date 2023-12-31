<?php

namespace parzival42codes\LaravelCodeOptimize\App\Services;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;

class PhpInsights
{
    public function dispatch(): Renderable
    {
        $path = '/tmp/phpinsights.json';

        $phpInsightsContent = [
            'summary' => [
                'code' => 0,
                'complexity' => 0,
                'architecture' => 0,
                'style' => 0,
                'security issues' => 0,
                'fixed issues' => 0,
            ],
            'Code' => [],
            'Complexity' => [],
            'Architecture' => [],
            'Style' => [],
            'Security' => [],
        ];

        $storageDisk = Storage::disk('storage');
        if ($storageDisk->exists($path)) {
            $contentFile = $storageDisk->get($path);
            if ($contentFile) {
                $content = json_decode($contentFile, true);
                if ($content) {
                    /** @var array $phpInsightsContent */
                    $phpInsightsContent = $content;
                }
            }
        }

        $phpInsightsTable = [];

        $phpInsightsSummary = $phpInsightsContent['summary'] ?? null;
        unset($phpInsightsContent['summary']);

        foreach ($phpInsightsContent as $part => $phpInsight) {
            foreach ($phpInsight as $phpInsightData) {
                $phpInsightsTable[$part][] = $phpInsightData;
            }
        }

        return View::make('code-optimize::phpinsights', compact([
            'phpInsightsSummary',
            'phpInsightsTable',
        ]));
    }
}
