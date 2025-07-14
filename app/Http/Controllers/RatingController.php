<?php

namespace App\Http\Controllers;

use App\Models\Concert;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function store(Request $request, Concert $concert)
    {
        $validated = $request->validate([
            'value' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $existing = Rating::where('concert_id', $concert->id)
            ->where('user_id', Auth::id())
            ->first();

        if ($existing) {
            return back()->with('error', 'Już oceniłeś ten koncert.');
        }

        Rating::create([
            'concert_id' => $concert->id,
            'user_id' => Auth::id(),
            'value' => $validated['value'],
            'comment' => $validated['comment'],
        ]);

        return back()->with('success', 'Dziękujemy za ocenę!');
    }

    public function edit(Rating $rating)
    {
        if ($rating->user_id !== Auth::id()) {
            abort(403);
        }

        return view('ratings.edit', compact('rating'));
    }

    public function update(Request $request, Rating $rating)
    {
        if ($rating->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'value' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $rating->update($validated);

        return back()->with('success', 'Twoja ocena została zaktualizowana.');
    }

    public function destroy(Rating $rating)
    {
        if ($rating->user_id !== Auth::id()) {
            abort(403);
        }

        $rating->delete();

        return back()->with('success', 'Twoja ocena została usunięta.');
    }
}
