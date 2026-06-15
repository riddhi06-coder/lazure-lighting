<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManageNavigation extends Model
{
    use HasFactory;

    protected $table = 'home_navigation';
    public $timestamps = false;

    protected $fillable = [
        'heading',
        'description',
        'image',
       
        'created_at',
        'created_by',
        'modified_at',
        'modified_by',
        'deleted_at',
        'deleted_by',
    ];

}
