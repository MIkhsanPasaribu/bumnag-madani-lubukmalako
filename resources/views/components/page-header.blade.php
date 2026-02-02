@props([
    'route' => null,
    'backText' => 'Kembali',
    'title' => '',
    'breadcrumb' => [],
])

<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        @if(count($breadcrumb) > 0)
            <nav class="flex items-center gap-2 text-sm text-gray-500 mb-2">
                @foreach($breadcrumb as $item)
                    @if(!$loop->last)
                        <a href="{{ $item['url'] }}" class="hover:text-primary transition-colors">{{ $item['label'] }}</a>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    @else
                        <span class="text-gray-900">{{ $item['label'] }}</span>
                    @endif
                @endforeach
            </nav>
        @endif
        <h1 class="text-2xl font-bold text-gray-900">{{ $title }}</h1>
        @if(isset($subtitle))
            <p class="text-gray-600 mt-1">{{ $subtitle }}</p>
        @endif
    </div>
    
    @if($route)
        <a href="{{ $route }}" class="btn-ghost w-full sm:w-auto justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            {{ $backText }}
        </a>
    @endif
    
    {{ $slot }}
</div>
