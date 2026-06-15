<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    use HasFactory;

    protected $table = 'sub_products_details';
    public $timestamps = false;

    protected $fillable = [
        'sec_title',
        'banner_image',
        'sub_product_id',
        'sub_product_description',
        'thumbnail_image',
        'gallery_images',
        'specifications',
        'features',

        'created_at',
        'created_by',
        'modified_at',
        'modified_by',
        'deleted_at',
        'deleted_by',
    ];

    public function subProduct()
    {
        return $this->belongsTo(SubProduct::class, 'sub_product_id', 'id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_name');
    }


}
