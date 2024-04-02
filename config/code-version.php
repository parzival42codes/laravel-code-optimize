<?php

return [

    /*
     * Main Version
     */
    'versions_required' => [
        'php' => '1.0.0',
        'blade' => '1.0.1',
        'table' => '1.0.0',
    ],

    /*
     * Path to scan
     */
    'scan_path' => [
        app_path(),
        //        base_path('/packages'),
    ],
    /*
     * Path to scan
     */
    'scan_class' => [
        'App\Http\Controllers\Controller',
    ],

];
