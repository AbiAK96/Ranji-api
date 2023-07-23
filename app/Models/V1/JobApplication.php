<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobApplication extends Model
{
    use SoftDeletes;
    use HasFactory;

    public $table = 'job_applications';
   
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];
    
   protected $fillable = [
       'vacancy_id',
       'user_id',
   ];

   /**
    * The attributes that should be cast.
    *
    * @var array<string, string>
    */
   protected $casts = [
       'vacancy_id' => 'integer',
       'user_id' => 'integer', 
   ];

    static function applyJob($id)
   {
       $jobApplicationDetails = [
           'vacancy_id' => $id,
           'user_id' => auth()->user()->id
       ];
   
       return JobApplication::create($jobApplicationDetails);
   }

   public function user()
   {
       return $this->hasOne('App\Models\V1\User', 'id', 'user_id');
   }
}
