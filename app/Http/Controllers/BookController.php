<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Author;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $categories = Category::all();
        $authors = Author::all();

        return view('admin.books.create', compact('categories', 'authors'));
    }


    public function store(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric|min:0',
        'stock' => 'required|integer|min:0',
        'isbn' => 'nullable|string',
        'category_id' => 'required|exists:gema_categories,id',
        'author' => 'required|string|max:255', // ini ganti author_id
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    $validated['slug'] = Str::slug($validated['title']);

    // cari atau buat penulis
    $author = Author::firstOrCreate(['name' => $validated['author']]);

    // jika ada gambar, simpan
    if ($request->hasFile('image')) {
        $validated['image'] = $request->file('image')->store('books', 'public');
    }

    // buat buku dengan author_id dari relasi
    Book::create([
        'title' => $validated['title'],
        'description' => $validated['description'],
        'price' => $validated['price'],
        'stock' => $validated['stock'],
        'isbn' => $validated['isbn'],
        'slug' => $validated['slug'],
        'category_id' => $validated['category_id'],
        'author_id' => $author->id,
        'image' => $validated['image'] ?? null,
    ]);

    return redirect()->route('admin.dashboard')->with('success', 'Book added successfully.');
}



    public function edit(Book $book)
    {
        $categories = Category::all();
        $authors = Author::all();

        return view('admin.books.edit', compact('book', 'categories', 'authors'));
    }

    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'isbn' => 'nullable|string',
            'category_id' => 'required|exists:gema_categories,id',
            'author_id' => 'required|exists:gema_authors,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);
        $validated['slug'] = Str::slug($validated['title']);

        if ($request->hasFile('image')) {
            if (!empty($book->image) && Storage::disk('public')->exists($book->image)) {
                Storage::disk('public')->delete($book->image);
            }
            $validated['image'] = $request->file('image')->store('books', 'public');
        }


        $book->update($validated);

        return redirect()->route('admin.dashboard')->with('success', 'Book updated successfully.');
    }

    public function destroy(Book $book)
    {
        $book->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Book deleted successfully.');
    }
}
