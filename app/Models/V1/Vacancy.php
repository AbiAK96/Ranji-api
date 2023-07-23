<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vacancy extends Model
{
    use SoftDeletes;
    use HasFactory;

    use SoftDeletes;
    public $table = 'vacancies';
   
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];
    
   protected $fillable = [
       'title',
       'working_hours',
       'description'
   ];

   /**
    * The attributes that should be cast.
    *
    * @var array<string, string>
    */
   protected $casts = [
       'title' => 'string',
       'working_hours' => 'string', 
       'description' => 'string',
   ];
}
