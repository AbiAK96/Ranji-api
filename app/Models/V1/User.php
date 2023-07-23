<?php

namespace App\Models\V1;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\URL;

class User extends Authenticatable
{
    use SoftDeletes;
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

     public $table = 'users';
    
     const CREATED_AT = 'created_at';
     const UPDATED_AT = 'updated_at';
 
 
     protected $dates = ['deleted_at'];
     
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'mobile',
        'profile_picture',
        'role',
        'address',
        'is_worker',
        'city',
        'postal_code',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
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
        'password' => 'string',
        'mobile' => 'string',
        'profile_picture' => 'string',
        'role' => 'string',
        'address' => 'string',
        'is_worker' => 'boolean',
        'city' => 'string',
        'postl_code' => 'string',
        'email_verified_at' => 'datetime'
    ];

    static function getExistingEmail($email){

        $user = User::where('email', $email)->first();
        if(null == $user){
            return true;
        }
        return false;
    }

    static function createUserDetails($request)
    {
        $userDetails = [
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'role' => 'user',
            'mobile' => $request->input('mobile'),
            'address' => $request->input('address'),
            'city' => $request->input('city'),
            'postal_code' => $request->input('postal_code'),
            'is_worker' => false,
        ];
    
        return User::create($userDetails);
    }

    static function updateUserDetails($request)
    {
        $uptDetails = User::where('id', auth()->user()->id)->update(
            array(
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'mobile' => $request->input('mobile'),
                'address' => $request->input('address'),
                'city' => $request->input('city'),
                'postal_code' => $request->input('postal_code'),
                )
            );

        return $uptDetails;
    }

    static function checkRegister($email)
    {
        $user = User::where('email', $email)
                            ->first();

        if(null != $user){
            return $user;
        }
        return false;
    }

    static function checkCreditials($email, $password)
    {
        $user = User::where('email', $email)->first();
        if (null != $user && Hash::check($password, $user->password)) {
            return $user;
        } else {
            return false;
        }
    }

    static function emailVerified($email)
    {
        $email = User::where('email', $email)->first()->email_verified_at;
        if ($email != null) {
            return $email;
        } else {
            return false;
        }
    }

    static function changePassword($user,$request)
    {
        if(Hash::check($request->old_password,$user->password)){
            $user->update([
                'password'=>Hash::make($request->new_password)
            ]);
        }else{
            return false;
        }
    }

    public function getProfilePictureAttribute($value)
    {
        $base_url = config('variable.base_url');
        if($value == null){
            return null;
        }
        return URL::to($base_url.'profile/').$value;
    }

    static function uploadProfilePicture($request)
    {
        $image_url = 'profile_picture'."_".time().".jpg";
        $path = public_path()."/profile/" . $image_url;
        $img = base64_decode($request->profile_picture);
        $success = file_put_contents($path, $img);
        return $image_url;
    }

    static function getFirstNameByEmail($email)
    {
        $first_name = User::where('email', $email)->first();
        return $first_name;
    }
}
