<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $table = 'gema_books';

    protected $fillable = [
        'title',
        'slug',
        'description',
        'price',
        'stock',
        'isbn',
        'image',
        'category_id',
        'author_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'gema_order_items')
            ->withPivot(['quantity', 'price']);
    }

    public function wishlistedBy()
    {
        return $this->belongsToMany(User::class, 'gema_wishlists')->withTimestamps();
    }
}
