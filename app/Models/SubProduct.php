<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubProduct extends Model
{
    use HasFactory;

    protected $table = 'sub_products';
    public $timestamps = false;

    protected $fillable = [
        'banner_title',
        'banner_image',
        'product_id',
        'application_id',
        'category_id',
        'sub_product',
        'thumbnail_image',
        'slug',
        'created_at',
        'created_by',
        'modified_at',
        'modified_by',
        'deleted_at',
        'deleted_by',
    ];

    // In SubProduct.php model
    public function category()
    {
        // assuming your categories table primary key is 'id' and foreign key in sub_products is 'category_id'
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    // In SubProduct.php
    public function application()
    {
        return $this->belongsTo(Applications::class, 'application_id');
    }


}
