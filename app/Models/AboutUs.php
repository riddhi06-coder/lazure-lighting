<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutUs extends Model
{
    use HasFactory;

    protected $table = 'about_us';
    public $timestamps = false;

    protected $fillable = [
        'banner_image',
        'banner_video',
        'thumbnail_image',
        'youtube_url',
        'heading',
        'heading_icon',
        'image_title',
        'extra_image',
        'description',
        'created_at',
        'created_by',
        'modified_at',
        'modified_by',
        'deleted_at',
        'deleted_by',
    ];

}
