<?php

namespace parzival42codes\LaravelCodeOptimize\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\App;
use parzival42codes\LaravelCodeOptimize\App\Services\EnlightnService;
use parzival42codes\LaravelCodeOptimize\App\Services\FailedJobService;
use parzival42codes\LaravelCodeOptimize\App\Services\JobService;
use parzival42codes\LaravelCodeOptimize\App\Services\Leasot;
use parzival42codes\LaravelCodeOptimize\App\Services\PhpCsService;
use parzival42codes\LaravelCodeOptimize\App\Services\PhpInsights;
use parzival42codes\LaravelCodeOptimize\App\Services\PhpMd;
use parzival42codes\LaravelCodeOptimize\App\Services\PhpStan;
use parzival42codes\LaravelCodeOptimize\App\Services\Unittest;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     */
    public function index(): Renderable
    {
        $unittest = App::make(Unittest::class)->dispatch();
        $phpstan = App::make(PhpStan::class)->dispatch();
        $phpInsights = App::make(PhpInsights::class)->dispatch();
        $phpmd = App::make(PhpMd::class)->dispatch();
        $phpcs = App::make(PhpCsService::class)->dispatch();
        $enlightn = App::make(EnlightnService::class)->dispatch();
        $leasot = App::make(Leasot::class)->dispatch();
        $jobs = App::make(JobService::class)->dispatch();
        $failedJobs = App::make(FailedJobService::class)->dispatch();

        return view('code-optimize::dashboard', compact([
            'unittest',
            'phpstan',
            'phpmd',
            'phpcs',
            'phpInsights',
            'enlightn',
            'leasot',
            'jobs',
            'failedJobs',
        ]));
    }
}
