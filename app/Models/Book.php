<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Book extends Model
{
    use HasFactory;

    protected $with = ["author"];

    protected $fillable = [
        "title",
        "author_id",
        "subtitle",
        "description",
        "preview",
        "cover",
    ];

    protected $appends = ["cover_url"];

    protected static function boot()
    {
        parent::boot();

        static::deleting(fn($book) => $book->removeFromWishlists());
    }

    public function author(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Author::class);
    }

    public function getCoverUrlAttribute()
    {
        $url = Storage::exists($this->cover)
            ? Storage::url($this->cover)
            : $this->cover;

        return asset($url);
    }

    public function wishlists()
    {
        return $this->belongsToMany(Wishlist::class);
    }

    public function removeFromWishlists()
    {
        $this->wishlists()->detach();
    }
}
