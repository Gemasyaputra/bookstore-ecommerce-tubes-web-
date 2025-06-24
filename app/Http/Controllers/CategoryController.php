<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show(Category $category)
    {
        $books = $category->books()->with('author')->paginate(12);
        
        return view('categories.show', compact('category', 'books'));
    }
    
    // Admin methods akan dibuat nanti
    public function index()
    {
        //
    }
    
    public function create()
    {
        //
    }
    
    public function store(Request $request)
    {
        //
    }
    
    public function edit(Category $category)
    {
        //
    }
    
    public function update(Request $request, Category $category)
    {
        //
    }
    
    public function destroy(Category $category)
    {
        //
    }
}