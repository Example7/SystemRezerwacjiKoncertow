@props(['tags'])

@if (!empty($tags) && count($tags))
    <div class="mt-1">
        @foreach ($tags as $tag)
            @php $tag = trim($tag); @endphp
            @if ($tag !== '')
                <span class="badge bg-dark px-2">
                    <a href="/?tag={{ $tag }}" class="text-white text-decoration-none">{{ $tag }}</a>
                </span>
            @endif
        @endforeach
    </div>
@endif
