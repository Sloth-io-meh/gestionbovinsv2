@props(['items'])

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">📊 Dashboard</a></li>
        @foreach($items as $label => $route)
            @if($loop->last)
                <li class="breadcrumb-item active" aria-current="page">{{ $label }}</li>
            @else
                <li class="breadcrumb-item"><a href="{{ $route }}">{{ $label }}</a></li>
            @endif
        @endforeach
    </ol>
</nav>

<style>
    .breadcrumb {
        background: transparent;
        padding: 0;
        margin-bottom: 20px;
        font-size: 0.9rem;
    }
    .breadcrumb-item + .breadcrumb-item::before {
        content: "›" !important;
        font-size: 1.2rem;
        vertical-align: middle;
        line-height: 1;
        padding-right: 0.5rem;
        padding-left: 0.5rem;
        color: #6c757d;
    }
</style>
