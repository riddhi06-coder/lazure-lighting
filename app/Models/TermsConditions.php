<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TermsConditions extends Model
{
    use HasFactory;

    protected $table = 'terms_conditions';
    public $timestamps = false;

    protected $fillable = [
        'banner_heading',
        'banner_image',
        'effective_date',
        'title',
        'description',
      
        'created_at',
        'created_by',
        'modified_at',
        'modified_by',
        'deleted_at',
        'deleted_by',
    ];
}
