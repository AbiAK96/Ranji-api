<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Job extends Model
{
    use SoftDeletes;
    use HasFactory;

    public $table = 'jobs';
    
     const CREATED_AT = 'created_at';
     const UPDATED_AT = 'updated_at';
 
 
     protected $dates = ['deleted_at'];
     
    protected $fillable = [
        'customer_id',
        'worker_id',
        'service_type_id',
        'title',
        'description',
        'status',
        'budget',
        'rating',
        'job_code',
        'preferred_date',
        'payment_type'
    ];

    protected $casts = [
        'customer_id' => 'string',
        'worker_id' => 'string', 
        'service_type_id' => 'string',
        'title' => 'string',
        'description' => 'string',
        'status' => 'string',
        'rating' => 'string',
        'job_code' => 'string',
        'preferred_date' => 'string',
        'payment_type' => 'string'
    ];

    public static function boot()
    {
        parent::boot();
    
            // create a event to happen on saving
            static::creating(function($table)  {
                $table->customer_id = auth()->user()->id;
                $table->job_code = '#'.auth()->user()->id.'-'.time();
            });
    }

    static function getJobDetailsForCustomer($request)
    {
        $query  = Job::with('jobAddress','payment')->where('customer_id',auth()->user()->id)->OrderBy('id', 'desc');

        if (isset($request->title)) {
            if ($request->title != null)
            {
                $query = $query->where('title', 'LIKE', "%{$request->title}%");
            }
        }

        return $query->paginate(10);
    }

    public function jobAddress()
    {
    	return $this->hasOne('App\Models\V1\JobAddress', 'job_id', 'id');
    }
    
    public function payment()
    {
    	return $this->hasOne('App\Models\V1\Payment', 'job_id', 'id');
    }

    static function getJobDetailsForAdmin($request)
    {
        $query  = Job::with('jobAddress','payment')->OrderBy('id', 'desc');
        if (isset($request->title)) {
            if ($request->title != null)
            {
                $query = $query->where('title', 'LIKE', "%{$request->title}%");
            }
        }
        return $query->paginate(10);
    }
}
