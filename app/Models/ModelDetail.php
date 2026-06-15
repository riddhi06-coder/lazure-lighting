<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelDetail extends Model
{
    use HasFactory;

    protected $table = 'model_details';
    public $timestamps = false;

    protected $fillable = [
        'sub_product_id',
        'product_image',
        'model_name',
        'model_no',
        'size',
        'wattage',
        'lumens',
        'cct',
        'cri',
        'beam_angle',
        'accessories',
        'dimming_options',
        'specssheet',
        'installation_manual',
        'drawings_2d',
        'drawings_3d',
        'light_application',
        'mounting_type',
        'ip_rating',
        'orientation',
        'optics',
        'spec_upload',
        'manual_upload',
        '2d_upload',
        '3d_upload',

        'created_at',
        'created_by',
        'modified_at',
        'modified_by',
        'deleted_at',
        'deleted_by',
    ];

    public function subProduct()
    {
        return $this->belongsTo(SubProduct::class, 'sub_product_id');
    }

}
