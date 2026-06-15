<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $table = 'projects';
    public $timestamps = false;

    protected $fillable = [
        'category_id',
        'project_name',
        'slug',
        'project_location',
        'thumbnail_image',
        
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

    // Project.php
    public function category()
    {
        return $this->belongsTo(ProjectCategory::class, 'category_id');
    }

}
