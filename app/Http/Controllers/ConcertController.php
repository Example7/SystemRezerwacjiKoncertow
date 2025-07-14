<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Artist;
use App\Models\Concert;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ConcertController extends Controller
{
    public function index()
    {
        $concerts = Concert::latest()->filter(request(['tag', 'search']))->paginate(8);
        return view('concerts.index', compact('concerts'));
    }

    public function show($id)
    {
        $concert = Concert::with('artists')->findOrFail($id);

        $upcomingConcerts = Concert::where('concert_date', '>=', Carbon::now())
            ->orderBy('concert_date')
            ->limit(4)
            ->get();

        return view('concerts.show', compact('concert', 'upcomingConcerts'));
    }

    public function create()
    {
        $locations = Location::all();
        $artists = Artist::all();
        return view('concerts.create', compact('locations', 'artists'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'tags' => 'nullable|string',
            'location_id' => 'required|exists:locations,id',
            'date' => 'required|date|after_or_equal:today',
            'price' => 'required|numeric|min:0',
            'available_tickets' => 'required|integer|min:1',
            'artists' => 'nullable|array',
            'artists.*' => 'exists:artists,id',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
        ]);

        $validated['user_id'] = Auth::id();

        $concert = Concert::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'tags' => $validated['tags'] ?? null,
            'location_id' => $validated['location_id'],
            'concert_date' => $validated['date'],
            'ticket_limit' => $validated['available_tickets'],
            'email' => $validated['email'] ?? null,
            'website' => $validated['website'] ?? null,
            'user_id' => $validated['user_id'],
        ]);

        if (!empty($validated['artists'])) {
            $concert->artists()->sync($validated['artists']);
        }

        for ($i = 0; $i < $validated['available_tickets']; $i++) {
            $concert->tickets()->create([
                'price' => $validated['price'],
                'reservation_id' => null,
            ]);
        }

        return redirect()->route('concerts.index')->with('success', 'Koncert został dodany!');
    }

    public function edit(Concert $concert)
    {
        $concert->load('tickets');
        $locations = Location::all();
        $artists = Artist::all();

        return view('concerts.edit', [
            'concert' => $concert,
            'locations' => $locations,
            'artists' => $artists,
        ]);
    }

    public function update(Request $request, Concert $concert)
    {
        if ($concert->user_id != Auth::id() && Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized Action');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'tags' => 'nullable|string',
            'location_id' => 'required|exists:locations,id',
            'date' => 'required|date|after_or_equal:today',
            'price' => 'required|numeric|min:0',
            'available_tickets' => 'required|integer|min:1',
            'artists' => 'nullable|array',
            'artists.*' => 'exists:artists,id',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
        ]);

        $concert->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'tags' => $validated['tags'] ?? null,
            'location_id' => $validated['location_id'],
            'concert_date' => $validated['date'],
            'ticket_limit' => $validated['available_tickets'],
            'email' => $validated['email'] ?? null,
            'website' => $validated['website'] ?? null,
        ]);

        if (!empty($validated['artists'])) {
            $concert->artists()->sync($validated['artists']);
        } else {
            $concert->artists()->detach();
        }

        $currentTicketsCount = $concert->tickets()->count();
        $newTicketsCount = $validated['available_tickets'];

        if ($newTicketsCount > $currentTicketsCount) {
            $ticketsToAdd = $newTicketsCount - $currentTicketsCount;
            for ($i = 0; $i < $ticketsToAdd; $i++) {
                $concert->tickets()->create([
                    'price' => $validated['price'],
                    'reservation_id' => null,
                ]);
            }
        } elseif ($newTicketsCount < $currentTicketsCount) {
            $ticketsToRemove = $currentTicketsCount - $newTicketsCount;
            $tickets = $concert->tickets()->whereNull('reservation_id')->take($ticketsToRemove)->get();

            if ($tickets->count() < $ticketsToRemove) {
                return back()->withErrors(['available_tickets' => 'Nie można zmniejszyć liczby biletów poniżej liczby już zarezerwowanych.']);
            }

            foreach ($tickets as $ticket) {
                $ticket->delete();
            }
        }

        $concert->tickets()->whereNull('reservation_id')->update(['price' => $validated['price']]);

        return redirect()->route('concerts.index', $concert)->with('success', 'Koncert został zaktualizowany!');
    }

    public function destroy(Concert $concert)
    {
        if ($concert->user_id != Auth::id()) {
            abort(403, 'Unathorized Action');
        }

        $concert->delete();
        return redirect('/')->with('success', 'Koncert został poprawnie usunięty');
    }

    public function manage()
    {
        /** @var User|null $user */
        $user = Auth::user();

        if (!$user) {
            abort(403, 'Unauthorized');
        }

        $query = null;

        if ($user->role === 'admin') {
            $query = Concert::query();
        } else {
            $query = $user->concerts();
        }

        $concerts = $query
            ->filter(request(['search']))
            ->latest()
            ->paginate(12);

        return view('concerts.manage', compact('concerts'));
    }
}
