<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogDetails extends Model
{
    use HasFactory;

    protected $table = 'blog_details';
    public $timestamps = false;

    protected $fillable = [
        'blog_id',
        'banner_image',
        'blog_heading',
        'blog_content',

        'status',
        'created_at',
        'created_by',
        'modified_at',
        'modified_by',
        'deleted_at',
        'deleted_by',
    ];
    
    // In BlogDetails.php (model)
    public function blog()
    {
        return $this->belongsTo(Blog::class, 'blog_id');
    }

}
