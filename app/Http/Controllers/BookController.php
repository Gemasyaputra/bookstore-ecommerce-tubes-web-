<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\Author;
use Illuminate\Http\Request;

class BookController extends Controller
{
    // Public method untuk customer
    public function index(Request $request)
    {
        $query = Book::with(['category', 'author']);
        
        // Filter by category
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }
        
        // Search by title
        if ($request->has('search') && $request->search != '') {
            $query->where('title', 'like', '%' . $request->search . '%');
        }
        
        $books = $query->paginate(12);
        $categories = Category::all();
        
        return view('books.index', compact('books', 'categories'));
    }
    
    public function show(Book $book)
    {
        $book->load(['category', 'author']);
        $relatedBooks = Book::where('category_id', $book->category_id)
                           ->where('id', '!=', $book->id)
                           ->take(4)
                           ->get();
        
        return view('books.show', compact('book', 'relatedBooks'));
    }
    
    // Admin methods (akan dibuat nanti)
    public function create()
    {
        //
    }
    
    public function store(Request $request)
    {
        //
    }
    
    public function edit(Book $book)
    {
        //
    }
    
    public function update(Request $request, Book $book)
    {
        //
    }
    
    public function destroy(Book $book)
    {
        //
    }
}