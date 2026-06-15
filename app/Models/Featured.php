<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Featured extends Model
{
    use HasFactory;

    protected $table = 'featured_products';
    public $timestamps = false;

    protected $fillable = [
        'section_heading',
        'banner_heading',
        'banner_title',
        'banner_images',
        'created_at',
        'created_by',
        'modified_at',
        'modified_by',
        'deleted_at',
        'deleted_by',
    ];
}
