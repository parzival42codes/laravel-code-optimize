<div id="jobss">

    <div class="card">
        <div class="card-header">Queue Jobs</div>
        <div class="card-body">
            <table class="table table-striped table-hover">
                <tr class="table-light">
                    <th>Queue</th>
                    <th>Attempts</th>
                    <th>Display Name</th>
                    <th>Command</th>
                    <th>Reserved</th>
                    <th>Available</th>
                    <th>Created</th>
                </tr>
                @foreach($jobs as $job)
                    <tr>
                        @php
                            $payload = json_decode($job->payload);
                            $command = unserialize($payload->data->command);
                            $property = new ReflectionProperty(get_class($command), 'data');
                            d($property->getValue($command));
                            d($payload);
                            d($command);
                        @endphp
                        <td>{{ $job->queue }}</td>
                        <td>{{ $job->attempts }}</td>
                        <td>{{ $payload->displayName }}</td>
                        <td>{{ $payload->data->command }}</td>
                        <td>{{ $job->reserved_at }}</td>
                        <td>{{ $job->available_at }}</td>
                        <td>{{ $job->created_at }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
