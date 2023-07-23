<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Mail\ForgotPassword;
use Carbon\Carbon;
use Illuminate\Support\Str;
use DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;

use App\Models\V1\User;

class UserController extends AppBaseController
{
    public function testFunction()
    {
      try {
        return $this->sendResponse(null, 'Test function working successfully',null);
    } catch (\Exception $e){
        return $this->sendResponse(null, null, 'Test function not working. '. $e->getMessage());
      }
    }

    public function customerRegistration(Request $request)
    {
        try 
        {
            $email = User::getExistingEmail($request->email);
            if(false == $email){
                return $this->sendResponse(null, null, 'Email is already taken');
            }else{
                $user = User::createUserDetails($request); 
                return $this->sendResponse($user, 'Customer registration successfully',null);
            }
        } catch (\Exception $e){
            return $this->sendResponse(null, null, 'Customer registration failed. '. $e->getMessage());
        }
    }

    public function login(Request $request)
    {
      try {
        $email = User::checkRegister($request['email']);
        if(false == $email) {
            return $this->sendResponse(null, null, 'Email not found');
        } else {
                $user = User::checkCreditials($request['email'], $request['password']);
                $response = [];
                if (false == $user) {
                    return $this->sendResponse($response, null, 'Invalid credentials');
                } else {
                        $token = $user->createToken('LoginToken')->plainTextToken;
                        $response['token'] = $token;
                        $response['user'] = $user;
                        return $this->sendResponse($response, 'Logged in successfully', null);
                    }
            }
        } catch (Exception $e) {
            return $this->sendResponse(null, null,'It\'s a technical error! Please reach out to our customer service.');
        }  
    }

    public function logout()
    {
        try {
            $user = auth('sanctum')->user();
            $user->tokens()->delete();
            return $this->sendResponse(null, 'User logout successfully', null);
        } catch (Exception $e) {
            return $this->sendResponse(null,null,'User logout failed '.$e->getMessage());
        }
    }

    
    public function currentUser(Request $request)
    {
        try {
            $user = auth()->user();
            if(!empty($user)){
                return $this->sendResponse($user, 'User Found Successfully.', null);
            } else {
                return $this->sendResponse(null, null, 'Can not found User.');
            }
        } catch (Exception $e) {
            return $this->sendResponse(null, null,'It\'s a technical error! Please reach out to our customer service.');
        }
    }

    public function updateProfile(Request $request)
    {
        try{ 
            $user = User::updateUserDetails($request);
            return $this->sendResponse(auth()->user(), 'User updated successfully', null);
        }catch(Exception $e){
            return $this->sendResponse(null,null,'User updating failed ');
        }
    }

    public function changePassword(Request $request)
    {
        try {
            $user = auth()->user();
            $user = User::changePassword($user,$request);
            if ($user === false) {
              return $this->sendResponse(null, null, 'Old password does not matched');
            }
            return $this->sendResponse($user, 'Password successfully updated', null);
        } catch (\Exception $e){
            return $this->sendResponse( null , null, 'Password updating failed');
        }
    }

    public function uploadProfileImage(Request $request)
    {
        try {
            $user = auth('sanctum')->user();
            $user->profile_picture = User::uploadProfilePicture($request);
            $respones = $user->update();
            if ($respones == true) {
                return $this->sendResponse($respones, 'Profile picture updated successfully', null);
            }else{
                return $this->sendResponse(null, null, 'Profile picture updating failed');
            }
        } catch (Exception $e) {
            return $this->sendResponse(null,null,'User updating failed '.$e->getMessage());
        }
    }

    public function forgotPassword(Request $request)
    {
        $email = User::checkRegister($request['email']);
        if(true != $email) {
            $message = 'Email address is not valid';
            return $this->sendResponse(null, null, $message);
        }
        $token = Str::random(40);
        $password_resets = DB::table('password_reset_tokens')->where('email', $request['email'])->first();
        if ($password_resets == null) {
            DB::table('password_reset_tokens')->insert([
                'email' => $request['email'],
                'token' => $token,
                'created_at' => Carbon::now()
            ]); 
        } else {
            DB::table('password_reset_tokens')->where('email', $request['email'])->update([
                'email' => $request['email'],
                'token' => $token,
                'created_at' => Carbon::now()
            ]);
        }
        $first_name = User::getFirstNameByEmail($request['email']);
        Mail::to($request['email'])->send(new ForgotPassword($token, $request['email'], $first_name));
        return $this->sendResponse(null, 'Please check your email inbox for instructions to reset your password', null);
    }
    
    public function updatePassword(Request $request, $id)
    {
		try{
			$input = Input::get();

            $uptDetails = User::where('id', $id)->update(
            array(
                'password' => (Hash::make($request->get('password')) != null) ? Hash::make($request->get('password')) : null,
                'updated_at' => now(),
                )
            );

			return redirect()->back()->with('message', 'Password Updated Successfully.');
		} catch(Exception $e) {
			//exception handling
			return back()->withError("Error!")->withInput($data);
			//echo $e;
		}
    }

    public function passwordResetProcess(Request $request)
    {
        return $this->updatePasswordRow($request)->count() > 0 ? $this->resetPassword($request) : $this->tokenNotFoundError();
    }
  
    public function resetPasswordView(Request $request)
    {
        return view('auth/password_reset')->with('request',$request);
    }

    private function updatePasswordRow($request)
    {
        return DB::table('password_reset_tokens')->where([
            'email' => $request->email,
            'token' => $request->token
        ]);
    }

    private function tokenNotFoundError() 
    {
        return view('auth/password_reset_failed'); 
    }

    private function resetPassword($request)
    {
        $user = User::whereEmail($request->email)->first();
        $user->update([
          'password'=>bcrypt($request->password)
        ]);
        $this->updatePasswordRow($request)->delete();
        return view('auth/password_reset_success'); 
    }
}
