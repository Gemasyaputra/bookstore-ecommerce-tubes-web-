<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;
        
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        return view('cart.index', compact('cart', 'total'));
    }
    
    public function add(Request $request, Book $book)
    {
        $cart = session()->get('cart', []);
        
        if (isset($cart[$book->id])) {
            $cart[$book->id]['quantity']++;
        } else {
            $cart[$book->id] = [
                'title' => $book->title,
                'price' => $book->price,
                'quantity' => 1,
                'author' => $book->author->name
            ];
        }
        
        session()->put('cart', $cart);
        
        return redirect()->back()->with('success', 'Book added to cart!');
    }
    
    public function remove($bookId)
    {
        $cart = session()->get('cart', []);
        
        if (isset($cart[$bookId])) {
            unset($cart[$bookId]);
            session()->put('cart', $cart);
        }
        
        return redirect()->back()->with('success', 'Book removed from cart!');
    }
    
    public function update(Request $request, $bookId)
    {
        $cart = session()->get('cart', []);
        
        if (isset($cart[$bookId])) {
            $cart[$bookId]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
        }
        
        return redirect()->back()->with('success', 'Cart updated!');
    }
}
