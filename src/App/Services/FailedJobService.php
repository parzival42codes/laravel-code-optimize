<?php

namespace parzival42codes\LaravelCodeOptimize\App\Services;

use DB;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\View;

class FailedJobService
{
    public function dispatch(): Renderable
    {
        $failedJobs = DB::table('failed_jobs')->get();

        d($failedJobs);

        return View::make('code-optimize::failedJobs', compact([
            'failedJobs',
        ]));
    }
}
