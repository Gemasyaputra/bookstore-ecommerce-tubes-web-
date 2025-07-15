<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $orders = Order::with('items.book') // Pastikan relasi sudah benar
                ->where('user_id', Auth::id())
                ->latest()
                ->get();

    return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function cancel(Order $order)
{
    // Pastikan user yang login adalah pemilik order
    if (auth()->id() !== $order->user_id) {
        abort(403);
    }

    // Hanya bisa cancel jika masih pending
    if ($order->status === 'pending') {
        $order->status = 'cancelled';
        $order->save();

        return redirect()->back()->with('success', 'Order has been cancelled.');
    }

    return redirect()->back()->with('error', 'This order cannot be cancelled.');
}


    
}
