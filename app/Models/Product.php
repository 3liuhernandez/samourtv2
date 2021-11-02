<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id',
        'name',
        'description',
        'thumbnail',
        'media',
        'author',
        'type'
    ];

    /**
     * Obtiene la categoríade un producto
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}

