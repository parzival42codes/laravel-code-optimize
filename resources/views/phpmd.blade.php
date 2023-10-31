@include('phpmd-view::header')

<div id="phpmdView">

    <div class="card">
        <div class="card-header">Zusammenfassung</div>
        <div class="card-body" style="display:flex;">
            <div style="flex: 1;">Files: <strong>{{ $phpMdStats['files'] ?? 0 }}</strong></div>
            <div style="flex: 1;">Entries: <strong>{{ $phpMdStats['entries'] ?? 0 }}</strong></div>
        </div>
    </div>

    @foreach ($phpMdJson['files'] as $phpMdJsonFiles)

        <div class="card">
            <div class="card-body">
                <table class="table table-striped table-hover">
                    <tr class="table-light">
                        <th>
                            Description
                        </th>
                        <th>
                            BeginLine
                        </th>
                        <th>
                            EndLine
                        </th>
                        <th>
                            RuleSet
                        </th>
                        <th>
                            Rule
                        </th>
                        <th>
                            Priority
                        </th>
                    </tr>

                    @foreach ($phpMdJsonFiles['violations'] as $violation)
                        @if (is_array($violation))
                            @php
//                                s($violation);
                            @endphp
                            <tr>
                                <td>
                                    {{ $violation['description'] }}
                                </td>
                                <td>
                                    {{ $violation['beginLine'] }}
                                </td>
                                <td>
                                    {{ $violation['endLine'] }}
                                </td>
                                <td>
                                    {{ $violation['ruleSet'] }}
                                </td>
                                <td>
                                    <a href="{{ $violation['externalInfoUrl'] }}" target="_blank">{{ $violation['rule'] }}</a>
                                </td>
                                <td>
                                    {{ $violation['priority'] }}
                                </td>
                            </tr>

                        @endif
                    @endforeach

                </table>
            </div>
            <div class="card-footer">{{ $phpMdJsonFiles['file'] }}</div>
        </div>

    @endforeach


</div>

@include('phpmd-view::footer')
