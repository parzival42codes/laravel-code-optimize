<?php

namespace parzival42codes\LaravelCodeOptimize;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelCodeOptimizeServiceProvider extends PackageServiceProvider
{
    public const PACKAGE_NAME = 'laravel-code-optimize';

    public const PACKAGE_NAME_SHORT = 'code-optimize';

    public function configurePackage(Package $package): void
    {
        $package->name(self::PACKAGE_NAME)->hasRoute('route')->hasViews();
    }

    public function registeringPackage(): void {}
}
