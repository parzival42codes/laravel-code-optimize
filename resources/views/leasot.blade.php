@include('leasot-view::header')

<div id="leasotView">
    @foreach ($leasotTags as $leasotTag => $leasotRef)

        @foreach ($leasotRef as $leasotsRefKey => $leasots)
            <div class="card">
                <div class="card-header">{{ $leasotTag }}:  {{ $leasotsRefKey }}</div>
                <div class="card-body">
                    <table class="table table-striped table-hover">
                        <tr class="table-light">
                            <th>
                                Text
                            </th>
                            <th>
                                File
                            </th>
                        </tr>

                        @foreach ($leasots as $leasot)
                            <tr>
                                <td>
                                    {{ $leasot['text'] }}
                                </td>
                                <td>
                                    {{ $leasot['file'] }} # {{ $leasot['line'] }}
                                </td>
                            </tr>
                        @endforeach

                    </table>
                </div>
            </div>

        @endforeach
    @endforeach
</div>


@include('leasot-view::footer')
