<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'title',
        'author',
        'publisher',
        'published_year',
        'category_id',
        'available_copies',
        'total_copies',
        'image_path',
        'synopsis',
    ];

        public function category()
        {
            return $this->belongsTo(Category::class);
        }
    
        public function loans()
        {
            return $this->hasMany(Loan::class);
        }
    
        public function reviews()
        {
            return $this->hasMany(Review::class);
        }
    
        public function reservations()
        {
            return $this->hasMany(Reservation::class);
        }
}
