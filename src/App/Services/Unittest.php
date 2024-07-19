<?php

namespace parzival42codes\LaravelCodeOptimize\App\Services;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Throwable;

class Unittest
{
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

                                if ($testArray) {
                                    $this->testStats = [
                                        'name' => $testArray['testsuite']['@attributes']['name'] ?? '',
                                        'tests' => $testArray['testsuite']['@attributes']['tests'] ?? 0,
                                        'assertions' => $testArray['testsuite']['@attributes']['assertions'] ?? 0,
                                        'errors' => $testArray['testsuite']['@attributes']['errors'] ?? 0,
                                        'failures' => $testArray['testsuite']['@attributes']['failures'] ?? 0,
                                        'skipped' => $testArray['testsuite']['@attributes']['skipped'] ?? 0,
                                        'time' => $testArray['testsuite']['@attributes']['time'] ?? 0,
                                    ];

                                    $this->testsuite($testArray['testsuite']['testsuite']);
                                }
                            }
                        }
                    }
                }
            }

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
        if (isset($testsuite['@attributes']['name'])) {
            if (isset($testsuite['testsuite'])) {
                if (! isset($testsuite['testsuite']['@attributes'])) {
                    foreach ($testsuite['testsuite'] as $testsuiteItem) {
                        if (isset($testsuiteItem['testcase']['@attributes'])) {
                            if (isset($testsuiteItem['testcase'])) {
                                $this->testcase($testsuiteItem);
                            }
                        } else {
                            if (isset($testsuiteItem['@attributes']['name'])) {
                                $name = $testsuiteItem['@attributes']['name'];
                                if (isset($testsuiteItem['testcase'])) {
                                    $this->checkName($name, $testsuiteItem['@attributes']);

                                    foreach ($testsuiteItem['testcase'] as $testCase) {
                                        if (isset($testCase['@attributes'])) {
                                            $this->addUnitTestSuits($name, $testCase);
                                        }
                                    }
                                } else {
                                    $this->testsuite($testsuiteItem);
                                }
                            }
                        }
                    }
                } else {
                    $this->testcase($testsuite['testsuite']);
                }
            } elseif (isset($testsuite['testcase'])) {
                $this->testcase($testsuite);
            }
        } else {
            foreach ($testsuite as $testsuiteItem) {
                $this->testsuite($testsuiteItem);
            }
        }
    }

    private function testcase(array $testcase)
    {
        $name = $testcase['@attributes']['name'];

        $this->checkName($name, $testcase['@attributes']);

        if (isset($testcase['testcase']['@attributes'])) {
            $this->addUnitTestSuits($name, $testcase['testcase']);
        } else {
            foreach ($testcase['testcase'] as $testcaseItem) {
                $this->addUnitTestSuits($name, $testcaseItem);
            }
        }
    }

    private function addUnitTestSuits(string $name, array $data): void
    {
        $this->unitTestSuits[$name]['entries'][] = array_merge($data['@attributes'], [
            'error' => $data['error'] ?? '',
            'failure' => $data['failure'] ?? '',
        ]);
    }

    private function checkName(string $name, array $attributes = [])
    {
        if (! isset($this->unitTestSuits[$name])) {
            $this->unitTestSuits[$name] = $attributes;
            $this->unitTestSuits[$name]['entries'] = [];
        }
    }
}
