<div id="phpstan">

    <div class="card">
        <div class="card-header">Zusammenfassung</div>
        <div class="card-body" style="display:flex;">
            <div style="flex: 1;">Error: <strong>{{ $phpStanJson['totals']['errors'] ?? 0 }}</strong></div>
            <div style="flex: 1;">File Error: <strong>{{ $phpStanJson['totals']['file_errors'] ?? 0 }}</strong></div>
        </div>
    </div>

    @foreach ($phpStanJson['files'] as $phpStanFile => $phpStanData)
        <div class="card">
            <div class="card-body">
                <table class="table table-striped table-hover">
                    <tr class="table-light">
                        <th>
                            Message
                        </th>
                        <th>
                            Line
                        </th>
                        <th>
                            Ignorable
                        </th>
                    </tr>
                    @foreach ($phpStanData['messages'] as $message)
                        <tr>
                            <td>
                                {{ $message['message'] }}
                            </td>
                            <td>
                                {{ $message['line'] }}
                            </td>
                            <td>
                                {{ $message['ignorable'] }}
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
            <div class="card-footer">{{ $phpStanFile }}</div>
        </div>
    @endforeach

</div>
