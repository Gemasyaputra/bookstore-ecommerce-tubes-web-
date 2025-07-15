<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Category;
use App\Models\Author;
use App\Models\User;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_books' => Book::count(),
            'total_categories' => Category::count(),
            'total_authors' => Author::count(),
            'total_users' => User::where('role', 'user')->count(),
            'low_stock_books' => Book::where('stock', '<', 10)->count(),
        ];

        $latestBooks = Book::latest()->paginate(10);

        return view('admin.dashboard', compact('stats', 'latestBooks'));
    }
}
