<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use SoftDeletes;
    use HasFactory;

    use SoftDeletes;
    public $table = 'payments';
   
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];
    
   protected $fillable = [
       'job_id',
       'user_id',
       'payment_type',
       'price',
       'reference_number'
   ];

   /**
    * The attributes that should be cast.
    *
    * @var array<string, string>
    */
   protected $casts = [
       'job_id' => 'string',
       'user_id' => 'integer', 
       'payment_type' => 'string',
       'price' => 'string',
       'reference_number' => 'string'
   ];


   static function createDetatils($job, $request)
   {
       $addressDetails = [
           'job_id' => $job->id,
           'user_id' => $job->customer_id,
           'payment_type' => $request->payment_type,
           'price' => $job->budget,
           'reference_number' => $request->reference_number
       ];

       $job->status = 'Completed';
       $job->update();
   
       return Payment::create($addressDetails);
   }
}
