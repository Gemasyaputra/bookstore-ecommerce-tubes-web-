<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class AdminOrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'items.book'])->latest()->get();

        return view('admin.orders.index', compact('orders'));
    }
    public function confirm(Order $order)
    {
        // Update status
        $order->status = 'success';
        $order->save();

        // Kurangi stok buku sesuai item yang dibeli
        foreach ($order->items as $item) {
            $book = $item->book;
            $book->stock -= $item->quantity;
            $book->save();
        }

        return redirect()->back()->with('success', 'Order has been confirmed as paid.');
    }
}
