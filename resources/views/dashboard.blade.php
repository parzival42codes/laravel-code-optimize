@include('code-optimize::header')

<ul class="nav nav-tabs" id="laravel-code-optimize-tabs" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button"
                role="tab" aria-controls="home" aria-selected="true">PHPInsights
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button"
                role="tab" aria-controls="profile" aria-selected="false">Leasot
        </button>
    </li>
</ul>

<div class="tab-content" id="laravel-code-optimize-content">
    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
        {!! $phpInsights !!}
    </div>
    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
        {!! $leasot !!}
    </div>
</div>

@include('code-optimize::footer')
