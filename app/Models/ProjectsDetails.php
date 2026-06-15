<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectsDetails extends Model
{
    use HasFactory;

    protected $table = 'project_details';
    public $timestamps = false;

    protected $fillable = [
        'project_id',
        'category_id',
        'banner_image',
        'project_image',
        'project_title',
        'project_description',
        'section_title',
        'highlights',
        'gallery_images',
        'created_at',
        'created_by',
        'modified_at',
        'modified_by',
        'deleted_at',
        'deleted_by',
    ];

    
    // 🔹 Correct relationship (foreign key = project_id)
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }


}
