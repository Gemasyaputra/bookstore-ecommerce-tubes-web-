<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredBooks = Book::with(['category', 'author'])
                            ->latest()
                            ->take(8)
                            ->get();
        
        $categories = Category::withCount('books')->get();
        
        return view('home', compact('featuredBooks', 'categories'));
    }
}