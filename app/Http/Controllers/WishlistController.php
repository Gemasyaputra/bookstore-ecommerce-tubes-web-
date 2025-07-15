<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Book;

class WishlistController extends Controller
{
    // Your existing methods...

    /**
     * Clear all items from the user's wishlist
     */
    public function clear()
    {
        $user = Auth::user();
        
        // Assuming you have a wishlist relationship on User model
        $user->wishlist()->detach();
        
        // Alternative if you have a Wishlist model:
        // Wishlist::where('user_id', $user->id)->delete();
        
        return redirect()->route('wishlist.index')->with('success', 'Your wishlist has been cleared successfully.');
    }

    /**
     * Share wishlist functionality
     */
    public function share()
    {
        $user = Auth::user();
        $wishlist = $user->wishlist; // Adjust based on your relationship
        
        // You can implement sharing logic here
        // For example, generate a shareable link or show sharing options
        
        return view('wishlist.share', compact('wishlist'));
    }

    // Example of existing methods structure (adjust based on your actual implementation)
    
    /**
     * Display the user's wishlist
     */
    public function index()
    {
        $user = Auth::user();
        $wishlist = $user->wishlist; // Adjust based on your relationship
        
        return view('wishlist.index', compact('wishlist'));
    }

    /**
     * Add a book to the wishlist
     */
    public function add(Book $book)
    {
        $user = Auth::user();
        
        // Check if book is already in wishlist
        if (!$user->wishlist()->where('book_id', $book->id)->exists()) {
            $user->wishlist()->attach($book->id);
            return redirect()->back()->with('success', 'Book added to wishlist successfully.');
        }
        
        return redirect()->back()->with('info', 'Book is already in your wishlist.');
    }

    /**
     * Remove a book from the wishlist
     */
    public function remove(Book $book)
    {
        $user = Auth::user();
        $user->wishlist()->detach($book->id);
        
        return redirect()->back()->with('success', 'Book removed from wishlist successfully.');
    }
}