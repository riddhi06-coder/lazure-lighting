<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clientele extends Model
{
    use HasFactory;

    protected $table = 'our_clientele';
    public $timestamps = false;

    protected $fillable = [
        'gallery_images',
    
        'created_at',
        'created_by',
        'modified_at',
        'modified_by',
        'deleted_at',
        'deleted_by',
    ];


}
