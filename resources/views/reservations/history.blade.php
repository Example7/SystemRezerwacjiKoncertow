<x-layout>
    <div class="container my-5">
        <a href="{{ route('concerts.index') }}" class="btn btn-outline-secondary mb-4">
            <i class="fa-solid fa-arrow-left"></i> Wróć
        </a>
        <h2 class="fw-bold text-primary mb-4">Twoja historia koncertów</h2>

        @if ($reservations->count())
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                @foreach ($reservations as $reservation)
                    @php
                        $concert = $reservation->concert;
                        $rating = $concert
                            ->ratings()
                            ->where('user_id', auth()->id())
                            ->first();
                    @endphp

                    <div class="col">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">{{ $concert->title }}</h5>
                                <p class="card-text">
                                    Miejsce: {{ $concert->location->name }}<br>
                                    Data: {{ $concert->concert_date->format('d.m.Y H:i') }}<br>
                                    Liczba biletów: {{ $reservation->ticket_count }}
                                </p>

                                @if ($rating)
                                    <div class="mb-2">
                                        <strong>Twoja ocena:</strong> {{ $rating->value }}/5<br>
                                        <small>{{ $rating->comment }}</small>
                                    </div>
                                    <a href="{{ route('ratings.edit', $rating) }}"
                                        class="btn btn-outline-primary btn-sm">
                                        <i class="fa-solid fa-pen"></i> Edytuj ocenę
                                    </a>

                                    <form action="{{ route('ratings.destroy', $rating) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Na pewno usunąć ocenę?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-outline-danger btn-sm">
                                            <i class="fa-solid fa-trash"></i> Usuń ocenę
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('ratings.store', $concert) }}" method="POST" class="mt-3">
                                        @csrf
                                        <div class="mb-2">
                                            <label>Ocena (1-5)</label>
                                            <input type="number" name="value" min="1" max="5" required
                                                class="form-control">
                                            @error('value')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="mb-2">
                                            <label>Komentarz</label>
                                            <textarea name="comment" class="form-control"></textarea>
                                            @error('comment')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <button class="btn btn-success btn-sm">
                                            <i class="fa-solid fa-star"></i> Zapisz ocenę
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4">
                {{ $reservations->links() }}
            </div>
        @else
            <div class="alert alert-info">Brak zrealizowanych koncertów.</div>
        @endif
    </div>
</x-layout>
