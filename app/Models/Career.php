<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Career extends Model
{
    use HasFactory;

    protected $table = 'career_page';
    public $timestamps = false;

    protected $fillable = [
        'banner_heading',
        'banner_image',
        'section_title',
        'section_image',
        'section_description',
        'value_heading',
        'our_values',
        'join_heading',
        'section_icon',
        'join_features',
        
        'role_heading',
        'roles_icon',
        'role_description',
        
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