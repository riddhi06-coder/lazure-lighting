<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductApplication extends Model
{
    use HasFactory;

    protected $table = 'product_applications';
    public $timestamps = false;

    protected $fillable = [
        'banner_title',
        'banner_image',
        'product_id',
        'section_heading',
        'section_desc',
        'on_off_images',
        'light_images',
        'meta_title',
        'meta_description',
        
        'cannonical',
        'hreflang',
        'og_tag',
        'twitter_card_tag',
        

        'created_at',
        'created_by',
        'modified_at',
        'modified_by',
        'deleted_at',
        'deleted_by',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }


}
