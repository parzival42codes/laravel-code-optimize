<div id="phpcs">

    <div class="card">
        <div class="card-header">Zusammenfassung</div>
        <div class="card-body" style="display:flex;">
            <div style="flex: 1;">Errors: <strong>{{ $phpcs['totals']['errors'] ?? 0 }}</strong></div>
            <div style="flex: 1;">Warnings: <strong>{{ $phpcs['warnings'] ?? 0 }}</strong></div>
            <div style="flex: 1;">Fixable: <strong>{{ $phpcs['totals']['fixable'] ?? 0 }}</strong></div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-striped table-hover">
                <tr class="table-light">
                    <th>
                        File
                    </th>
                    <th>
                        Errors
                    </th>
                    <th>
                        Warnings
                    </th>
                    <th>
                        Messages
                    </th>
                </tr>

                @foreach ($phpcs['files'] as $phpcsFile => $phpcsData)
                    @if ($phpcsData['errors'] || $phpcsData['warnings'] || $phpcsData['messages'])

                        <tr>
                            <td>
                                {{ str_replace(base_path(), '', $phpcsFile) }}
                            </td>
                            <td>
                                {{ $phpcsData['errors'] }}
                            </td>
                            <td>
                                {{ $phpcsData['warnings'] }}
                            </td>
                            <td>
                                @if ($phpcsData['messages'])
                                    <table class="table table-striped table-hover">
                                        <tr>
                                            <th>Message:</th>
                                            <th>Source:</th>
                                            <th>Severity:</th>
                                            <th>Fixable:</th>
                                            <th>Type:</th>
                                            <th>Line:</th>
                                            <th>Column:</th>
                                        </tr>
                                    @foreach ($phpcsData['messages'] as $message)
                                            <tr>
                                                <td>{{ $message['message'] }}</td>
                                                <td>{{ $message['source'] }}</td>
                                                <td>{{ $message['severity'] }}</td>
                                                <td>{{ (int)$message['fixable'] }}</td>
                                                <td>{{ $message['type'] }}</td>
                                                <td>{{ $message['line'] }}</td>
                                                <td>{{ $message['column'] }}</td>
                                            </tr>
                                    @endforeach
                                    </table>
                                @endif
                            </td>
                        </tr>
                    @endif
                @endforeach

            </table>
        </div>

    </div>

</div>

