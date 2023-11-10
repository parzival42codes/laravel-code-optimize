@include('code-optimize::header')

<ul class="nav nav-tabs" id="laravel-code-optimize-tabs" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="unittest-tab" data-bs-toggle="tab" data-bs-target="#unittest" type="button"
                role="tab" aria-controls="unittest" aria-selected="true">Unit Test
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="phpstan-tab" data-bs-toggle="tab" data-bs-target="#phpstan" type="button"
                role="tab" aria-controls="phpstan" aria-selected="true">PHPStan
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="phpmd-tab" data-bs-toggle="tab" data-bs-target="#phpmd" type="button"
                role="tab" aria-controls="phpmd" aria-selected="true">PHPMD
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="phpcs-tab" data-bs-toggle="tab" data-bs-target="#phpcs" type="button"
                role="tab" aria-controls="phpcs" aria-selected="true">PHPCS
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="phpInsights-tab" data-bs-toggle="tab" data-bs-target="#phpInsights" type="button"
                role="tab" aria-controls="phpInsights" aria-selected="true">PHPInsights
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="leasot-tab" data-bs-toggle="tab" data-bs-target="#leasot" type="button"
                role="tab" aria-controls="leasot" aria-selected="false">Leasot
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="jobs-tab" data-bs-toggle="tab" data-bs-target="#jobs" type="button"
                role="tab" aria-controls="jobs" aria-selected="false">Queue Jobs
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="failedJobs-tab" data-bs-toggle="tab" data-bs-target="#failedJobs" type="button"
                role="tab" aria-controls="failedJobs" aria-selected="false">Failed Queue Jobs
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="codeVersion-tab" data-bs-toggle="tab" data-bs-target="#codeVersion" type="button"
                role="tab" aria-controls="codeVersion" aria-selected="false">Code Version
        </button>
    </li>
</ul>

<div class="tab-content" id="laravel-code-optimize-content">
    <div class="tab-pane show active" id="unittest" role="tabpanel" aria-labelledby="unittest-tab">
        {!! $unittest !!}
    </div>
    <div class="tab-pane" id="phpstan" role="tabpanel" aria-labelledby="phpstan-tab">
        {!! $phpstan !!}
    </div>
    <div class="tab-pane" id="phpmd" role="tabpanel" aria-labelledby="phpmd-tab">
        {!! $phpmd !!}
    </div>
    <div class="tab-pane" id="phpcs" role="tabpanel" aria-labelledby="phpcs-tab">
        {!! $phpcs !!}
    </div>
    <div class="tab-pane" id="phpInsights" role="tabpanel" aria-labelledby="phpInsights-tab">
        {!! $phpInsights !!}
    </div>
    <div class="tab-pane" id="leasot" role="tabpanel" aria-labelledby="leasot-tab">
        {!! $leasot !!}
    </div>
    <div class="tab-pane" id="jobs" role="tabpanel" aria-labelledby="jobs-tab">
        {!! $jobs !!}
    </div>
    <div class="tab-pane" id="failedJobs" role="tabpanel" aria-labelledby="failedJobs-tab">
        {!! $failedJobs !!}
    </div>
    <div class="tab-pane" id="codeVersion" role="tabpanel" aria-labelledby="codeVersion-tab">
        {!! $codeVersion !!}
    </div>
</div>

@include('code-optimize::footer')
