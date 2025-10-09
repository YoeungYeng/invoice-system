<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory, HasApiTokens;
    protected $fillable = [
        "name",
        "stock_qty",
        "price",
        "discount",
        "image",
        "category_id"
    ];


    public function category()
    {
        return $this->belongsTo(Category::class);
    }


}
