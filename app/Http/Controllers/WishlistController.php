<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlist = Auth::user()->wishlist;
        return view('wishlist.index', compact('wishlist'));
    }

    public function add($bookId)
    {
        $user = Auth::user();

        if (!$user->wishlist->contains($bookId)) {
            $user->wishlist()->attach($bookId);
        }

        return back()->with('success', 'Book added to wishlist!');
    }

    public function remove($bookId)
    {
        Auth::user()->wishlist()->detach($bookId);

        return back()->with('success', 'Book removed from wishlist!');
    }
}

