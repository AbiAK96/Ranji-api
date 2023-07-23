<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\URL;

class Service extends Model
{
    use SoftDeletes;
    use HasFactory;

    public $table = 'services';
    
     const CREATED_AT = 'created_at';
     const UPDATED_AT = 'updated_at';
 
 
     protected $dates = ['deleted_at'];
     
    protected $fillable = [
        'service_category_id',
        'service',
        'image'
    ];

    protected $casts = [
        'service_category_id' => 'integer',
        'service' => 'string',
        'image' => 'string'
    ];

    public function serviceCategory()
    {
    	return $this->hasOne('App\Models\V1\Service', 'id', 'service_category_id');
    }

    public static function getServicesByCategoryId($id)
    {
        return Service::where('service_category_id',$id)->get();
    }

    public function getImageAttribute($value)
    {
        $base_url = config('variable.base_url');
        return URL::to($base_url.'service/').$value;
    }

    public static function boot()
    {
        parent::boot();
    
            // create a event to happen on saving
            static::creating(function($table)  {
                $base_url = config('variable.base_url');
                $data = explode($base_url.'service/',$table->image);
				$image = $data[1];
                $table->image = Service::uploadImage($image);
            });
    }

    public static function uploadImage($image)
    {
        $image_url = 'service'."_".time().".jpg";
        $path = public_path() . "/service/" . $image_url;
        $img = base64_decode($image);
        $success = file_put_contents($path, $img);
        return ($image_url);
    }
}
