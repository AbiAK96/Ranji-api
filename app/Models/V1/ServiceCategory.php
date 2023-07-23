<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceCategory extends Model
{
    use SoftDeletes;
    use HasFactory;

    public $table = 'service_categories';
    
     const CREATED_AT = 'created_at';
     const UPDATED_AT = 'updated_at';
 
 
     protected $dates = ['deleted_at'];
     
    protected $fillable = [
        'category',
    ];

    protected $casts = [
        'category' => 'string'
    ];

    public function service()
    {
    	return $this->hasMany('App\Models\V1\ServiceCategory', 'service_category_id', 'id');
    }
}
