<?php

namespace parzival42codes\LaravelCodeOptimize\App\Services;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;

class Unittest
{
    private array $unitTestTable = [];

    private array $unitTestSuits = [];

    public function dispatch(): Renderable
    {
        $path = '/tmp/unittest.xml';

        $testStats = [
            'name' => 0,
            'tests' => 0,
            'assertions' => 0,
            'errors' => 0,
            'failures' => 0,
            'skipped' => 0,
            'time' => 0,
        ];

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
                                /** @var array $testSuite1 */
                                $testSuite1 = $testArray['testsuite'];

                                $testStats = [
                                    'name' => $testSuite1['@attributes']['name'],
                                    'tests' => $testSuite1['@attributes']['tests'],
                                    'assertions' => $testSuite1['@attributes']['assertions'],
                                    'errors' => $testSuite1['@attributes']['errors'],
                                    'failures' => $testSuite1['@attributes']['failures'],
                                    'skipped' => $testSuite1['@attributes']['skipped'],
                                    'time' => $testSuite1['@attributes']['time'],
                                ];

                                $this->testSuit($testSuite1['testsuite']);

                                foreach ($this->unitTestSuits as $unitTestKey => $unitTestSuit) {
                                    if (isset($this->unitTestTable[$unitTestKey])) {
                                        $this->unitTestSuits[$unitTestKey]['entries'] = $this->unitTestTable[$unitTestKey];
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        $unitTestSuits = $this->unitTestSuits;

        return View::make('code-optimize::unittest', compact([
            'unitTestSuits',
            'testStats',
        ]));
    }

    private function testSuit(array $testsuite): void
    {
        foreach ($testsuite as $testsuiteEntry) {
            $this->testSuitEntry($testsuiteEntry);
        }
    }

    private function testSuitEntry(array|string $testsuiteEntry): void
    {
        if (is_string($testsuiteEntry)) {
            return;
        }

        if (isset($testsuiteEntry['@attributes'])) {
            $this->unitTestSuits[$testsuiteEntry['@attributes']['name']] = $testsuiteEntry['@attributes'];
        }

        if (isset($testsuiteEntry['testsuite'])) {
            $this->testSuit($testsuiteEntry['testsuite']);
        }

        if (isset($testsuiteEntry['testcase'])) {
            $this->testCase($testsuiteEntry['testcase']);
        }

        if (isset($testsuiteEntry['tests'])) {
            $this->testCaseItem(['@attributes' => $testsuiteEntry]);
        }

        if (is_array($testsuiteEntry)) {
            $this->testSuit($testsuiteEntry);
        }
    }

    private function testCase(array $testcase): void
    {
        if (isset($testcase['@attributes'])) {
            $this->testCaseItem($testcase);
        } else {
            foreach ($testcase as $testcaseItem) {
                $this->testCaseItem($testcaseItem);
            }
        }
    }

    private function testCaseItem(array $testcaseItem): void
    {
        $attributes = $testcaseItem['@attributes'];
        $attributes['error'] = $testcaseItem['error'] ?? '';
        $attributes['failure'] = $testcaseItem['failure'] ?? '';

        if (isset($attributes['class'])) {
            $this->unitTestTable[$attributes['class']][$attributes['name']] = $attributes;

            if (str_contains($attributes['class'], 'Tests\Unit')) {
                $attributes['name'] = $attributes['class'].'\\'.$attributes['name'];
                $attributes['class'] = 'Unit';
            }
        }
    }
}
