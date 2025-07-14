<x-layout>
    <div class="container my-5">
        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary mb-4">
            <i class="fa-solid fa-arrow-left"></i> Wróć
        </a>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="d-flex align-items-center gap-2">
                <h2 class="fw-bold text-primary mb-0">Twoje Rezerwacje</h2>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
        @endif

        @if ($reservations->count())
            <div class="table-responsive shadow-sm">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Koncert</th>
                            <th>Data</th>
                            <th>Ilość biletów</th>
                            <th>Akcja</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reservations as $reservation)
                            <tr>
                                <td class="fw-semibold">
                                    <i class="fa-solid fa-music text-primary me-1"></i>
                                    {{ $reservation->concert->title }}
                                </td>
                                <td>
                                    <i class="fa-solid fa-calendar-days text-secondary me-1"></i>
                                    {{ \Carbon\Carbon::parse($reservation->concert->concert_date)->format('d.m.Y H:i') }}
                                </td>
                                <td>
                                    <span class="badge bg-primary">
                                        {{ $reservation->ticket_count }}
                                    </span>
                                </td>
                                <td>
                                    @if ($reservation->concert->concert_date->isFuture())
                                        <form action="{{ route('reservations.destroy', $reservation) }}" method="POST"
                                            onsubmit="return confirm('Na pewno chcesz anulować tę rezerwację?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger">
                                                <i class="fa-solid fa-xmark"></i> Anuluj
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-muted">Zakończony</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $reservations->links() }}
            </div>
        @else
            <div class="alert alert-info shadow-sm">
                <i class="fa-solid fa-info-circle me-2"></i> Nie masz jeszcze żadnych rezerwacji.
            </div>
        @endif
    </div>
</x-layout>
