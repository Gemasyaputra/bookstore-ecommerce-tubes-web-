@extends('layouts.app')

@section('title', 'Add New Book')

@section('content')
    <div class="container mt-4">
        <h2>Add New Book</h2>
        <p class="text-muted">Fill in the details below to create a new book entry.</p>

        <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Title -->
            <div class="mb-3">
                <label for="title" class="form-label">Book Title</label>
                <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror"
                    value="{{ old('title') }}" required>
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Description -->
            <div class="mb-3">
                <label for="description" class="form-label">Description (optional)</label>
                <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror"
                    rows="3">{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Price -->
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" step="0.01" name="price" id="price"
                    class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}" required>
                @error('price')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Stock -->
            <div class="mb-3">
                <label for="stock" class="form-label">Stock</label>
                <input type="number" name="stock" id="stock"
                    class="form-control @error('stock') is-invalid @enderror" value="{{ old('stock', 0) }}" required>
                @error('stock')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- ISBN -->
            <div class="mb-3">
                <label for="isbn" class="form-label">ISBN</label>
                <input type="text" name="isbn" id="isbn" class="form-control @error('isbn') is-invalid @enderror"
                    value="{{ old('isbn') }}" required>
                @error('isbn')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Category -->
            <div class="mb-3">
                <label for="category_id" class="form-label">Category</label>
                <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror"
                    required>
                    <option value="">-- Choose Category --</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Author -->
            <div class="mb-3">
                <label for="author_id" class="form-label">Author</label>
                <select name="author_id" id="author_id" class="form-select @error('author_id') is-invalid @enderror"
                    required>
                    <option value="">-- Choose Author --</option>
                    @foreach ($authors as $author)
                        <option value="{{ $author->id }}" {{ old('author_id') == $author->id ? 'selected' : '' }}>
                            {{ $author->name }}
                        </option>
                    @endforeach
                </select>
                @error('author_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Image -->
            <div class="mb-3">
                <label for="image" class="form-label">Book Cover (Image)</label>
                <input type="file" class="form-control @error('image') is-invalid @enderror" id="image"
                    name="image">
                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>


            <!-- Submit -->
            <div class="d-grid mt-4">
                <button type="submit" class="btn btn-success btn-lg">
                    <i class="fas fa-plus-circle me-1"></i> Add Book
                </button>
            </div>
        </form>
    </div>
@endsection
