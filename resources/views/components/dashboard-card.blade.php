@props(['title', 'description' => '', 'icon' => 'fas fa-folder', 'route', 'buttonText' => 'Ver'])

<div class="card bg-base-100 shadow-xl hover:shadow-2xl transition-shadow">
    <figure class="px-10 pt-10">
        <div class="rounded-full bg-primary/10 p-6">
            <i class="{{ $icon }} text-5xl text-primary"></i>
        </div>
    </figure>
    <div class="card-body items-center text-center">
        <h2 class="card-title">{{ $title }}</h2>
        @if($description)
            <p>{{ $description }}</p>
        @endif
        <div class="card-actions">
            <a href="{{ $route }}" class="btn btn-primary">
                <i class="fas fa-eye mr-2"></i>{{ $buttonText }}
            </a>
        </div>
    </div>
</div>
