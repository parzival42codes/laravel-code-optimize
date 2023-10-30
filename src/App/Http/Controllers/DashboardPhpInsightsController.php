<?php

namespace parzival42codes\LaravelCodeOptimize\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\Storage;

class DashboardPhpInsightsController extends Controller
{
    /**
     * Show the application dashboard.
     */
    public function index(): Renderable
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
            $phpInsightsContent = json_decode($storageDisk->get($path), true);
        }

        $phpInsightsTable = [];

        $phpInsightsSummary = $phpInsightsContent['summary'];
        unset($phpInsightsContent['summary']);

        foreach ($phpInsightsContent as $part => $phpInsight) {
            foreach ($phpInsight as $phpInsightData) {
                $phpInsightsTable[$part][] = $phpInsightData;
            }
        }

        d($phpInsightsTable);

        return view('code-optimize::dashboardPhpInsights', compact([
            'phpInsightsTable',
        ]));
    }
}
