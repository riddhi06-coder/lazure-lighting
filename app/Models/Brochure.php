<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brochure extends Model
{
    use HasFactory;

    protected $table = 'brochure';
    public $timestamps = false;

    protected $fillable = [
        'banner_heading',
        'banner_image',
        'section_title',
        'thumbnail_image',
        'document_file',

        'created_at',
        'created_by',
        'modified_at',
        'modified_by',
        'deleted_at',
        'deleted_by',
    ];

}
