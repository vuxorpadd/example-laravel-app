<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Author extends Model
{
    use HasFactory;

    protected $fillable = ["name", "birthdate", "bio", "photo"];
    protected $casts = ["birthdate" => "date:Y-m-d"];
    protected $appends = ["photo_url"];

    public function books(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Book::class);
    }

    public function getPhotoUrlAttribute()
    {
        $url = Storage::exists($this->photo)
            ? Storage::url($this->photo)
            : $this->photo;

        return asset($url);
    }
}
