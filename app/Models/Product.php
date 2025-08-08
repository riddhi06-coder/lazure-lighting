<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    public $timestamps = false;

    protected $fillable = [
        'banner_title',
        'banner_image',
        'application_id',
        'category_id',
        'product',
        'thumbnail_image',
        'slug',
        'created_at',
        'created_by',
        'modified_at',
        'modified_by',
        'deleted_at',
        'deleted_by',
    ];

    public function application()
    {
        return $this->belongsTo(Applications::class, 'application_id');
    }


    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

}
