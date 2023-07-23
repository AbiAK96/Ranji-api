<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProvideService extends Model
{
    use SoftDeletes;
    use HasFactory;

    public $table = 'provide_services';
    
     const CREATED_AT = 'created_at';
     const UPDATED_AT = 'updated_at';
 
 
     protected $dates = ['deleted_at'];
     
    protected $fillable = [
        'service'
    ];

    protected $casts = [
        'service' => 'string'
    ];
}
