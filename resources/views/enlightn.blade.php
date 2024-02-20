<div id="phpcs">

    <div class="card">
        <div class="card-body">
            <table class="table table-striped table-hover">
                <tr class="table-light">
                    <th>
                        Messages
                    </th>
                    <th>
                        Status
                    </th>
                </tr>

                @foreach ($enlightnTable as $enlightn)
                    <tr>
                        <td>
                            {{ $enlightn['message'] }}
                        </td>
                        <td>
                            <div style="color:
                            @if($enlightn['status'] == 'Not Applicable')
                                blue
                            @elseif($enlightn['status'] == 'Passed')
                                green
                            @elseif($enlightn['status'] == 'Failed')
                                red
                            @endif
                            "> {{ $enlightn['status'] }} </div>
                        </td>

                    </tr>
                @endforeach

            </table>
        </div>

    </div>

</div>

