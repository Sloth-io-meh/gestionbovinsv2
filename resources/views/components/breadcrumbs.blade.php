@props(['items'])

<nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb bg-transparent px-0 pt-1 pb-0 mb-0 text-sm">
        <li class="breadcrumb-item">
            <a class="text-dark opacity-5" href="{{ route('dashboard') }}">Dashboard</a>
        </li>
        @foreach($items as $label => $route)
            @if($loop->last)
                <li class="breadcrumb-item text-dark active" aria-current="page">{{ $label }}</li>
            @else
                <li class="breadcrumb-item">
                    <a class="text-dark opacity-5" href="{{ $route }}">{{ $label }}</a>
                </li>
            @endif
        @endforeach
    </ol>
</nav>
