@props(['concert'])

<div class="col-md-6 mb-4">
    <x-card>
        <div class="row g-0">
            <div class="col-md-4 d-flex align-items-center justify-content-center">
                <img src="{{ asset('images/concert-logo.png') }}" class="img-fluid rounded-start p-2" alt="concert">
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h4 class="card-title text-truncate" style="max-width: 100%;">
                        {{ $concert->title }}
                    </h4>

                    <p class="card-text mb-1">
                        <i class="fa-solid fa-calendar-days"></i>
                        {{ \Carbon\Carbon::parse($concert->concert_date)->format('d M Y H:i') }}
                    </p>

                    @if ($concert->location)
                        <div class="text-lg mt-4">
                            <i class="fa-solid fa-location-dot"></i>
                            {{ $concert->location->name }}
                        </div>
                    @endif

                    <p>
                        <i class="fa-solid fa-money-bill-wave"></i>
                        Cena biletu: {{ number_format($concert->ticket_price, 2) }} PLN
                    </p>

                    <x-concert-tags :tags="$concert->tags_array" />

                    <a href="{{ route('concerts.show', $concert->id) }}" class="btn btn-primary btn-sm mt-3">
                        Zobacz szczegóły
                    </a>
                </div>
            </div>
        </div>
    </x-card>
</div>
