<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OurJourney extends Model
{
    use HasFactory;

    protected $table = 'our_journey';
    public $timestamps = false;

    protected $fillable = [
        'banner_image',
        'year',
        'achievement',
        'heading_icon',
        'description',
      
        'created_at',
        'created_by',
        'modified_at',
        'modified_by',
        'deleted_at',
        'deleted_by',
    ];
}
