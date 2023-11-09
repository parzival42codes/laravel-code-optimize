<?php

namespace parzival42codes\LaravelCodeOptimize\App\Services;

use DB;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\View;

class JobService
{
    public function dispatch(): Renderable
    {
        $jobs = DB::table('jobs')->orderByDesc('created_at')->get();

        return View::make('code-optimize::jobs', compact([
            'jobs',
        ]));
    }
}
