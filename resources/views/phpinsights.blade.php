<div id="phpinsights">
    @foreach ($phpInsightsTable as $phpInsightsPart => $phpInsights)
        <div class="card">
            <div class="card-header">{{ ucfirst($phpInsightsPart) }}: {{ $phpInsightsSummary[strtolower($phpInsightsPart)] ?? '' }}</div>
            <div class="card-body">
                <table class="table table-striped table-hover">
                    <tr class="table-light">
                        <th>Title</th>
                        <th>Message</th>
                        <th>InsightClass</th>
                        <th>File</th>
                        <th>Line</th>
                    </tr>
                    @foreach ($phpInsights as $insight)
                        <tr>
                            <td>{{ $insight['title'] ?? '' }}</td>
                            <td>{{ $insight['message'] ?? '' }}</td>
                            <td>{{ $insight['insightClass'] ?? '' }}</td>
                            <td>{{ $insight['file'] ?? '' }}</td>
                            <td>{{ $insight['line'] ?? '' }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    @endforeach
</div>
