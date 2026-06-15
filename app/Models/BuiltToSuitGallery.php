<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuiltToSuitGallery extends Model
{
    use HasFactory;

    protected $table = 'built_to_suit_gallery';
    public $timestamps = false;

    protected $fillable = [
        'banner_heading',
        'banner_image',
        'project_name',
        'priority',
        'slug',
        'thumbnail_image',
        'gallery_images',
       
        'inserted_at',
        'inserted_by',
        'modified_at',
        'modified_by',
        'deleted_at',
        'deleted_by',
    ];

}
