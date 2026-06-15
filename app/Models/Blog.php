<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $table = 'blogs';
    public $timestamps = false;

    protected $fillable = [
        'banner_title',
        'banner_image',
        'blog_title',
        'slug',
        'blog_date',
        'blog_image',
        'status',
        
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
}
