<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuiltToSuit extends Model
{
    use HasFactory;

    protected $table = 'built_to_suit';
    public $timestamps = false;

    protected $fillable = [
        'banner_heading',
        'banner_image',
        'section_image',
        'section_icon',
        'features',
        'section_title',
        'section_description',
        'process_details',
        'gallery',
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
