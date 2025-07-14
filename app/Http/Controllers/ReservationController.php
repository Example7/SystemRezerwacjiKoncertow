<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Concert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::with('concert')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('reservations.index', compact('reservations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'concert_id' => 'required|exists:concerts,id',
            'ticket_count' => 'required|integer|min:1',
        ]);

        $concert = Concert::findOrFail($validated['concert_id']);

        $availableTickets = $concert->tickets()
            ->whereNull('reservation_id')
            ->take($validated['ticket_count'])
            ->get();

        if ($availableTickets->count() < $validated['ticket_count']) {
            return back()->withErrors([
                'ticket_count' => 'Brak wystarczającej liczby biletów.'
            ])->withInput();
        }

        $reservation = Reservation::create([
            'user_id' => Auth::id(),
            'concert_id' => $concert->id,
            'ticket_count' => $validated['ticket_count'],
        ]);

        foreach ($availableTickets as $ticket) {
            $ticket->update(['reservation_id' => $reservation->id]);
        }

        return redirect()
            ->route('concerts.show', $concert->id)
            ->with('success', 'Rezerwacja została dokonana!');
    }

    public function history()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $reservations = $user
            ->reservations()
            ->with(['concert.location'])
            ->whereHas('concert', function ($query) {
                $query->where('concert_date', '<', now());
            })
            ->latest()
            ->paginate(10);

        return view('reservations.history', compact('reservations'));
    }


    public function destroy(Reservation $reservation)
    {
        if ($reservation->user_id !== Auth::id()) {
            abort(403);
        }

        $reservation->tickets()->update(['reservation_id' => null]);

        $reservation->delete();

        return redirect()
            ->route('reservations.index')
            ->with('success', 'Rezerwacja została anulowana.');
    }
}
