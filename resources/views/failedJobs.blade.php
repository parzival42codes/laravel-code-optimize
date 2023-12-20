<div id="failedJobs">

    <div class="card">
        <div class="card-header">Queue Jobs</div>
        <div class="card-body">
            <table class="table table-striped table-hover">
                <tr class="table-light">
                    <th style="width: 5%;">Connection</th>
                    <th style="width: 5%;">Queue</th>
                    <th style="width: 35%;">Payload</th>
                    <th style="width: 35%;">Exception</th>
                    <th style="width: 10%;">Failed At</th>
                </tr>
                @foreach ($failedJobs as $failedJob)
                    @php
                        $payload = json_decode($failedJob->payload);
                        $command = unserialize($payload->data->command);
                        $property = new ReflectionProperty(get_class($command), 'data');
                        $data = $property->getValue($command);
                    @endphp
                    <tr>
                        <td>{{ $failedJob->connection }}</td>
                        <td>{{ $failedJob->queue }}</td>
                        <td><details><summary>Payload</summary><code style="word-break: break-word;">{{ var_export($data,true) }}</code></details></td>
                        <td><details><summary>Exception</summary><code style="word-break: break-word;">{{ var_export($failedJob->exception,true) }}</code></details></td>
                        <td>{{ $failedJob->failed_at }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
