<?php

namespace parzival42codes\LaravelCodeOptimize\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\App;
use parzival42codes\LaravelCodeOptimize\App\Services\CodeVersionService;
use parzival42codes\LaravelCodeOptimize\App\Services\Leasot;
use parzival42codes\LaravelCodeOptimize\App\Services\PhpInsights;
use parzival42codes\LaravelCodeOptimize\App\Services\PhpMd;
use parzival42codes\LaravelCodeOptimize\App\Services\PhpStan;
use parzival42codes\LaravelCodeOptimize\App\Services\Unittest;

class DashboarController extends Controller
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
        $leasot = App::make(Leasot::class)->dispatch();
        $codeVersion = App::make(CodeVersionService::class)->dispatch();

        return view('code-optimize::dashboard', compact([
            'unittest',
            'phpstan',
            'phpmd',
            'phpInsights',
            'leasot',
            'codeVersion',
        ]));
    }
}
