<?php

namespace parzival42codes\LaravelCodeOptimize\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\App;
use parzival42codes\LaravelCodeOptimize\App\Services\Leasot;
use parzival42codes\LaravelCodeOptimize\App\Services\PhpInsights;

class DashboarController extends Controller
{
    /**
     * Show the application dashboard.
     */
    public function index(): Renderable
    {
        $phpInsights = App::make(PhpInsights::class)->dispatch();
        $leasot = App::make(Leasot::class)->dispatch();

        return view('code-optimize::dashboard', compact([
            'phpInsights',
            'leasot',
        ]));
    }
}
