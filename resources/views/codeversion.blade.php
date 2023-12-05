<div id="codeVersion">

    <div class="card">
        <div class="card-header">Code Versionen</div>
        <div class="card-body">

            <table class="table table-striped table-hover">
                <tr class="table-light">
                    <th>Class</th>
                    <th colspan="{{ $versionsTD }}">Versions</th>
                </tr>

                @foreach ($codeData as $code)
                    @if ($code['versionDoc'])
                        <tr>
                            <td>{{ $code['discover'] }}</td>
                            @foreach ($versions as $versionKey => $version)
                                <td>{{ $versionKey }}
                                    @if (!empty($code['note'][$versionKey]))
                                        ({{ $code['note'][$versionKey] }})
                                    @endisset</td>
                                <td>{{ $code['version'][$versionKey] ?? '' }}</td>
                                <td class="versionCompare">
                                    @isset($code['versionCompare'][$versionKey])
                                        @if ($code['versionCompare'][$versionKey] === -1)
                                            <span style="color:yellow;">Lower</span>
                                        @elseif ($code['versionCompare'][$versionKey] === 0)
                                            <span style="color:lime;">Equal</span>
                                        @elseif ($code['versionCompare'][$versionKey] === 1)
                                            <span style="color:red;">Higher</span>
                                        @endif
                                    @else
                                        <span style="color:white;">No Data</span>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @else
                        <tr>
                            <td>{{ $code['discover'] }}</td>
                            <td colspan="{{ $versionsTD }}" class="versionCompare"><span
                                    style="color:red;">Class has no Data</span></td>
                        </tr>
                    @endif
                @endforeach

            </table>

        </div>
    </div>
</div>
