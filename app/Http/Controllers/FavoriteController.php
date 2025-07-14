<?php

namespace App\Http\Controllers;

use App\Models\Concert;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $favorites = $user->favoriteConcerts()->with('location')->latest()->paginate(9);

        return view('favorites.index', compact('favorites'));
    }

    public function toggle(Concert $concert)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->favoriteConcerts()->where('concert_id', $concert->id)->exists()) {
            $user->favoriteConcerts()->detach($concert->id);
            return back()->with('success', 'Koncert usunięty z ulubionych!');
        } else {
            $user->favoriteConcerts()->attach($concert->id);
            return back()->with('success', 'Koncert dodany do ulubionych!');
        }
    }
}
