<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'category';
    public $timestamps = false;

    protected $fillable = [
        'banner_title',
        'banner_image',
        'category',
        'application_id',
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

    public function application()
    {
        return $this->belongsTo(Applications::class, 'application_id');
    }

    
    
}
