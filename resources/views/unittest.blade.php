@include('unittest-view::header')

<div id="unittestView">

    <div class="card">
        <div class="card-body">
            <table class="table table-striped table-hover">
                <tr class="table-light">
                    <th>
                        Name
                    </th>
                    <th>
                        Tests
                    </th>
                    <th>
                        Assertions
                    </th>
                    <th>
                        Errors
                    </th>
                    <th>
                        Failures
                    </th>
                    <th>
                        Skipped
                    </th>
                    <th>
                        Time
                    </th>
                </tr>
                <tr>
                    <td>
                        {{ $testStats['name'] }}
                    </td>
                    <td>
                        {{ $testStats['tests'] }}
                    </td>
                    <td>
                        {{ $testStats['assertions'] }}
                    </td>
                    <td @if ($testStats['errors'] > 0) style="color: red;" @endif>
                        {{ $testStats['errors'] }}
                    </td>
                    <td @if ($testStats['failures'] > 0) style="color: red;" @endif>
                        {{ $testStats['failures'] }}
                    </td>
                    <td>
                        {{ $testStats['skipped'] }}
                    </td>
                    <td>
                        {{ round($testStats['time'],2) }} sec.
                    </td>
                </tr>
            </table>
        </div>
    </div>

    @foreach ($unitTestSuits as $unitTestSuit)

        @isset($unitTestSuit['entries'])

            <div class="card">
                <div class="card-header text-center extendedException-title">
                    {{ $unitTestSuit['name'] }}
                </div>

                <div class="card-body">


                    <div class="unittestContainer">
                        <div class="unittestContainer--item unittestContainer--item-test">Tests: <span
                                class="unittestContainer--item--value">{{ $unitTestSuit['tests'] }}</span></div>
                        <div
                            class="unittestContainer--item unittestContainer--item-assertions">Assertions: <span
                                class="unittestContainer--item--value">{{ $unitTestSuit['assertions'] }}</span></div>
                        <div
                            class="unittestContainer--item unittestContainer--item-errors">Errors: <span
                                class="unittestContainer--item--value" @if ($unitTestSuit['errors'] > 0) style="color: red;" @endif>{{ $unitTestSuit['errors'] }}</span></div>
                        <div
                            class="unittestContainer--item unittestContainer--item-failures">Failures: <span
                                class="unittestContainer--item--value" @if ($unitTestSuit['failures'] > 0) style="color: red;" @endif>{{ $unitTestSuit['failures'] }}</span></div>
                        <div
                            class="unittestContainer--item unittestContainer--item-skipped">Skipped: <span
                                class="unittestContainer--item--value">{{ $unitTestSuit['skipped'] }}</span></div>
                        <div
                            class="unittestContainer--item unittestContainer--item-time">Time: <span
                                class="unittestContainer--item--value">{{ round($unitTestSuit['time'],2) }} sec.</span>
                        </div>
                    </div>

                    <table class="table table-striped table-hover">
                        <tr class="table-light">
                            <th>Name</th>
                            <th>Assertions</th>
                            <th>Error</th>
                            <th>Failure</th>
                            <th>Time</th>
                        </tr>

                        @isset($unitTestSuit['entries'])

                            @foreach ($unitTestSuit['entries'] as $entry )

                                <tr>
                                    <td class="unitTestSuit--entry-name">{{ $entry['name'] }}</td>
                                    <td class="unitTestSuit--entry-assertions">{{ $entry['assertions'] }}</td>
                                    <td class="unitTestSuit--entry-error">{{ $entry['error'] }}</td>
                                    <td class="unitTestSuit--entry-failure">{{ $entry['failure'] }}</td>
                                    <td class="unitTestSuit--entry-time">{{ round($entry['time'],2) }} sec.</td>
                                </tr>

                            @endforeach

                        @endisset
                    </table>
                </div>
            </div>

        @endisset

    @endforeach


</div>

@include('unittest-view::footer')
