<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

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
        $currentQty = $cart[$book->id]['quantity'] ?? 0;
        $newQty = $currentQty + 1;

        if ($newQty > $book->stock) {
            return redirect()->back()->with('error', 'Not enough stock for "' . $book->title . '". Only ' . $book->stock . ' left.');
        }

        $cart[$book->id] = [
            'title' => $book->title,
            'price' => $book->price,
            'quantity' => $newQty,
            'author' => $book->author->name
        ];

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Book added to cart!');
    }

    public function update(Request $request, $bookId)
    {
        $cart = session()->get('cart', []);
        $book = Book::findOrFail($bookId);
        $newQty = $request->quantity;

        if ($newQty > $book->stock) {
            return redirect()->back()->with('error', 'Only ' . $book->stock . ' in stock for "' . $book->title . '".');
        }

        if ($newQty < 1) {
            unset($cart[$bookId]);
        } else {
            $cart[$bookId]['quantity'] = $newQty;
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Cart updated!');
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

    public function checkout()
    {
        $cart = session()->get('cart', []);
        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        return view('checkout.index', compact('cart', 'total'));
    }

    public function processCheckout(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string|max:255',
            'payment_method' => 'required|string',
        ]);

        $cart = session()->get('cart', []);

        // 🔒 Cek stok satu per satu sebelum proses
        foreach ($cart as $bookId => $item) {
            $book = Book::find($bookId);
            if (!$book || $item['quantity'] > $book->stock) {
                return redirect()->route('cart.index')->with('error', 'Stock not enough for "' . $item['title'] . '".');
            }
        }

        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        $order = Order::create([
            'user_id' => auth()->id(),
            'status' => 'pending',
            'total' => $total,
            'payment_method' => $request->payment_method,
            'shipping_address' => $request->shipping_address,
        ]);

        foreach ($cart as $bookId => $item) {
            $order->items()->create([
                'book_id' => $bookId,
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);

            // Kurangi stok
            $book = Book::find($bookId);
            $book->stock -= $item['quantity'];
            $book->save();
        }

        session()->forget('cart');

        return redirect()->route('orders.index')->with('success', 'Order placed successfully!');
    }
}
