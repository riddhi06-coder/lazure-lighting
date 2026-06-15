<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectCategory extends Model
{
    use HasFactory;

    protected $table = 'project_category';
    public $timestamps = false;

    protected $fillable = [
        'category_name',
        'slug',
        'banner_image',
        
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


    public function projects()
    {
        return $this->hasMany(Project::class, 'category_id');
    }


}
