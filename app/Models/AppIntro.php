<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppIntro extends Model
{
    use HasFactory;

    protected $table = 'app_intro';
    public $timestamps = false;

    protected $fillable = [
        'application_type_id',
        'banner_image',
        'application_info',
        'application_details',
        'created_at',
        'created_by',
        'modified_at',
        'modified_by',
        'deleted_at',
        'deleted_by',
    ];
}
