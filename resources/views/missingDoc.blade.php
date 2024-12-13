<div id="missingdoc">

    <div class="card">
        <div class="card-header">Missing Docs</div>
        <div class="card-body" style="text-align: center; display: flex;">
            <div style="flex: 1;">
                {{ $missingDocCounter }} Missing Doc
            </div>
            <div style="flex: 1;">
                {{ $missingDocClassCounter }} Missing Class
            </div>
            <div style="flex: 1;">
                {{ $missingDocPropertyCounter }} Missing Properties
            </div>
            <div style="flex: 1;">
                {{ $missingDocMethodCounter }} Missing Methods
            </div>

        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-striped table-hover">
                <tr class="table-light">
                    <th>
                        Class
                    </th>
                    <th>
                        Method
                    </th>
                    <th>
                        Line Start
                    </th>
                    <th>
                        Line End
                    </th>
                </tr>

                @foreach ($missingDoc as $missingDocClass)
                    @foreach ($missingDocClass as $missingType)
                    @foreach ($missingType as $missing)
                        <tr>
                            <td>
                                {{ $missing['name'] }}
                            </td>
                            <td>
                                {{ $missing['method'] }}
                            </td>
                            <td>
                                {{ $missing['lineStart'] }}
                            </td>
                            <td>
                                {{ $missing['lineEnd'] }}
                            </td>
                        </tr>
                    @endforeach
                    @endforeach
                @endforeach

            </table>
        </div>

    </div>

</div>
