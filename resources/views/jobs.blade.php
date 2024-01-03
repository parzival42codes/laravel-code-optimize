<div id="jobs">

    <div class="card">
        <div class="card-header">Queue Jobs</div>
        <div class="card-body">
            <table class="table table-striped table-hover">
                <tr class="table-light">
                    <th style="width: 5%;">Queue</th>
                    <th style="width: 5%;">Attempts</th>
                    <th style="width: 20%;">Display Name</th>
                    <th style="width: 40%;">Command</th>
                    <th style="width: 10%;">Reserved</th>
                    <th style="width: 10%;">Available</th>
                    <th style="width: 10%;">Created</th>
                </tr>
                @foreach ($jobs as $job)
                    <tr>
                        @php
                            $data = '';

                            $payload = json_decode($job->payload);
                            $command = unserialize($payload->data->command);

                            if (property_exists($command,'data')) {
                                $property = new ReflectionProperty(get_class($command), 'data');
                                $data = $property->getValue($command);
                            }
                        @endphp
                        <td>{{ $job->queue }}</td>
                        <td>{{ $job->attempts }}</td>
                        <td>{{ $payload->displayName }}</td>
                        <td>
                            <details>
                                <summary>Payload</summary>
                                <code style="word-break: break-word;">{{ var_export($data,true) }}</code></details>
                        </td>
                        <td>{{ date('Y-m-d H:i:s',$job->reserved_at) }}</td>
                        <td>{{ date('Y-m-d H:i:s',$job->available_at) }}</td>
                        <td>{{ date('Y-m-d H:i:s',$job->created_at) }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
