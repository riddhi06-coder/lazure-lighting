<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LightApplications extends Model
{
    use HasFactory;

    protected $table = 'light_applications';
    public $timestamps = false;

    protected $fillable = [
        'light_application_type',
        'sub_category_id',
        'thumbnail_image',
        'slug',
        
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
