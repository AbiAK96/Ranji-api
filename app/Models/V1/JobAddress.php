<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class JobAddress extends Model
{
    use SoftDeletes;
     public $table = 'job_address';
    
     const CREATED_AT = 'created_at';
     const UPDATED_AT = 'updated_at';
 
 
     protected $dates = ['deleted_at'];
     
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'mobile',
        'address',
        'city',
        'postal_code',
        'job_id'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'first_name' => 'string',
        'last_name' => 'string', 
        'email' => 'string',
        'mobile' => 'string',
        'address' => 'string',
        'city' => 'string',
        'postl_code' => 'string',
        'job_id' => 'integer'
    ];


    static function createDetatils($id, $request)
    {
        $addressDetails = [
            'job_id' => $id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'city' => $request->city,
            'postal_code' => $request->postal_code,
        ];
    
        return JobAddress::create($addressDetails);
    }

    public static function getAddressByJobId($job_id)
    {
        return JobAddress::where('job_id',$job_id)->get();
    }
}
