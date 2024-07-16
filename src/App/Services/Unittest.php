<?php

namespace parzival42codes\LaravelCodeOptimize\App\Services;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Throwable;

class Unittest
{
    private array $unitTestTable = [];

    private array $unitTestSuits = [];

    private array $testStats = [
        'name' => '',
        'tests' => 0,
        'assertions' => 0,
        'errors' => 0,
        'failures' => 0,
        'skipped' => 0,
        'time' => 0,
    ];

    public function dispatch(): Renderable
    {
        $unitTestSuits = rescue(function () {
            $path = '/tmp/unittest.xml';

            $storageDisk = Storage::disk('storage');

            if ($storageDisk->exists($path)) {
                $storageDiskContent = $storageDisk->get($path);
                if ($storageDiskContent) {
                    $xml = simplexml_load_string($storageDiskContent);
                    if ($xml) {
                        $json = json_encode($xml);

                        if ($json) {
                            if (! json_last_error()) {
                                /** @var array $testArray */
                                $testArray = json_decode($json, true);

                                d($testArray);

                                if ($testArray) {
                                    /** @var array $testSuite1 */
                                    $testSuite1 = $testArray['testsuite'];

                                    d($testSuite1['testsuite']);

                                    foreach ($testSuite1['testsuite'] as $testsuite) {
                                        if (isset($testsuite['@attributes'])) {
                                            $this->testStats = [
                                                'name' => $this->testStats['name'].' / '.$testsuite['@attributes']['name'],
                                                'tests' => $this->testStats['tests'] + $testsuite['@attributes']['tests'] ?? 0,
                                                'assertions' => $this->testStats['assertions'] + $testsuite['@attributes']['assertions'] ?? 0,
                                                'errors' => $this->testStats['errors'] + $testsuite['@attributes']['errors'] ?? 0,
                                                'failures' => $this->testStats['failures'] + $testsuite['@attributes']['failures'] ?? 0,
                                                'skipped' => $this->testStats['skipped'] + $testsuite['@attributes']['skipped'] ?? 0,
                                                'time' => $this->testStats['time'] + $testsuite['@attributes']['time'] ?? 0,
                                            ];

                                            if (isset($testsuite['testsuite']['testcase'])) {
                                                $this->testcase($testsuite);
                                            } else {
                                                $this->testsuite($testsuite);
                                            }
                                        }
                                    }

                                    $this->singleTestsuite($testSuite1);
                                }
                            }
                        }
                    }
                }
            }

            d($this->unitTestSuits);

            return $this->unitTestSuits;
        }, function (Throwable $throwable) {
            return [];
        });

        $testStats = $this->testStats;

        return View::make('code-optimize::unittest', compact([
            'unitTestSuits',
            'testStats',
        ]));
    }

    private function testsuite(array $testsuite)
    {
        $name = $testsuite['@attributes']['name'];

        $this->unitTestSuits[$name] = $testsuite['@attributes'];

        if (isset($testsuite['testsuite'])) {
            foreach ($testsuite['testsuite'] as $testsuiteItem) {
                $this->checkCollect($name);

                if (! isset($this->unitTestSuits[$name])) {
                    $this->unitTestSuits[$name] = [];
                }

                if (isset($testsuiteItem['testcase']['@attributes'])) {
                    $class = $testsuiteItem['testcase']['@attributes']['class'];
                    $this->checkClass($name, $class);

                    $this->unitTestSuits[$name]['collect'][$class]['entries'][] = array_merge($testsuiteItem['testcase']['@attributes'],
                        [
                            'error' => $testsuiteItem['testcase']['error'] ?? '',
                            'failure' => $testsuiteItem['testcase']['failure'] ?? '',
                        ]);
                } else {
                    if (isset($testsuiteItem['@attributes']['name'])) {
                        $class = $testsuiteItem['@attributes']['name'];
                        $this->checkClass($name, $class);

                        $this->unitTestSuits[$name]['collect'][$class] = $testsuiteItem['@attributes'];
                        $this->unitTestSuits[$name]['collect'][$class]['entries'] = [];
                        if (isset($testsuiteItem['testcase'])) {
                            foreach ($testsuiteItem['testcase'] as $testCase) {
                                if (isset($testCase['@attributes'])) {
                                    $this->unitTestSuits[$name]['collect'][$class]['entries'][] = array_merge($testCase['@attributes'],
                                        [
                                            'error' => $testCase['error'] ?? '',
                                            'failure' => $testCase['failure'] ?? '',
                                        ]);
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    private function testcase(array $testcase)
    {
        $name = $testcase['@attributes']['name'];

        $this->unitTestSuits[$name] = $testcase['@attributes'];
        $this->unitTestSuits[$name]['collect'] = [];

        $class = $testcase['testsuite']['@attributes']['name'];
        $this->checkClass($name, $class);

        $this->unitTestSuits[$name]['collect'][$class] = $testcase['testsuite']['@attributes'];
        $this->unitTestSuits[$name]['collect'][$class]['entries'] = [];

        foreach ($testcase['testsuite']['testcase'] as $testsuite) {
            $this->unitTestSuits[$name]['collect'][$class]['entries'][] = array_merge($testsuite['@attributes'], [
                'error' => $testsuite['error'] ?? '',
                'failure' => $testsuite['failure'] ?? '',
            ]);
        }
    }

    private function singleTestsuite(array $testsuite)
    {
        $this->testStats = [
            'name' => $testsuite['testsuite']['@attributes']['name'],
            'tests' => $testsuite['testsuite']['@attributes']['tests'],
            'assertions' => $testsuite['testsuite']['@attributes']['assertions'],
            'errors' => $testsuite['testsuite']['@attributes']['errors'],
            'failures' => $testsuite['testsuite']['@attributes']['failures'],
            'skipped' => $testsuite['testsuite']['@attributes']['skipped'],
            'time' => $testsuite['testsuite']['@attributes']['time'],
        ];

        $name = $testsuite['testsuite']['@attributes']['name'];

        $this->unitTestSuits[$name] = $testsuite['@attributes'];
        $this->unitTestSuits[$name]['collect'] = [];

        d($testsuite);

        foreach ($testsuite['testsuite']['testsuite'] as $testsuiteItem) {
            $class = $testsuiteItem['@attributes']['name'];
            $this->checkClass($name, $class);

            $this->unitTestSuits[$name]['collect'][$class] = $testsuiteItem['@attributes'];
            $this->unitTestSuits[$name]['collect'][$class]['entries'] = [];

            if (isset($testsuiteItem['testcase'])) {
                foreach ($testsuiteItem['testcase'] as $testsuiteValue) {
                    if (isset($testsuiteValue['@attributes'])) {
                        $this->unitTestSuits[$name]['collect'][$class]['entries'][] = array_merge($testsuiteValue['@attributes'],
                            [
                                'error' => $testsuiteValue['error'] ?? '',
                                'failure' => $testsuiteValue['failure'] ?? '',
                            ]);
                    }
                }
            }
        }

        d($this->unitTestSuits);
    }

    private function checkCollect(string $name)
    {
        if (! isset($this->unitTestSuits[$name]['collect'])) {
            $this->unitTestSuits[$name]['collect'] = [];
        }
    }

    private function checkClass(string $name, string $class)
    {
        if (! isset($this->unitTestSuits[$name]['collect'][$class])) {
            $this->unitTestSuits[$name]['collect'][$class] = [];
        }
    }
}
