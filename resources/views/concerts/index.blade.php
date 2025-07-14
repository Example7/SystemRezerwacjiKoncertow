<x-layout>

    @include('partials._hero')
    @include('partials._search')
    <div class="row">
        @forelse ($concerts as $concert)
            <x-concert-card :concert="$concert" />
        @empty
            <p class="text-center">Brak dostępnych koncertów.</p>
        @endforelse
    </div>
    <div mt-4 p-2>
        {{ $concerts->links() }}
    </div>

</x-layout>
