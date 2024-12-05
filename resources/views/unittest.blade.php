<div id="unittestContainer">

    <div class="card">
        <div class="card-body">
            <table class="table table-summary table-striped table-hover">
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

    @foreach ($unitTestSuits as $unitTestSuitName => $unitTestSuit)
        <div class="card">
            <div class="card-header text-center">
                <h2>{{ $unitTestSuitName }}</h2>
                <div style="font-size: small">
                    Tests: <b>{{ $unitTestSuit['tests'] ?? 0 }}</b>
                    Assertions: <b>{{ $unitTestSuit['assertions'] ?? 0 }}</b>
                    Errors: <b
                        @if ($unitTestSuit['errors'] ?? 0) style="color: red;" @endif>{{ $unitTestSuit['errors'] ?? 0 }}</b>
                    Failures: <b
                        @if ($unitTestSuit['failures'] ?? 0) style="color: red;" @endif>{{ $unitTestSuit['failures'] ?? 0 }}</b>
                    Skipped: <b>{{ $unitTestSuit['skipped'] ?? 0 }}</b>
                    Time: <b>{{ round($unitTestSuit['time'] ?? 0,2) }}</b>
                </div>
            </div>

            <div class="card-body">
                <table class="table table-striped table-hover">
                    <tr class="table-light">
                        <th>Name</th>
                        <th>Assertions</th>
                        <th>Error</th>
                        <th>Failure</th>
                        <th>Time</th>
                    </tr>

                    @foreach ($unitTestSuit['entries'] as $entry)
                        <tr>
                            <td class="unitTestSuit--entry-name">{{ $entry['name'] }}</td>
                            <td class="unitTestSuit--entry-assertions">{{ $entry['assertions'] }}</td>
                            <td class="unitTestSuit--entry-error">{{ $entry['error'] ?? '?' }}</td>
                            <td class="unitTestSuit--entry-failure">{{ $entry['failure'] ?? '?' }}</td>
                            <td class="unitTestSuit--entry-time">{{ round($entry['time'],2) }} sec.</td>
                        </tr>
                    @endforeach

                </table>
            </div>
        </div>

    @endforeach

</div>
