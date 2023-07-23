<?php

namespace App\Http\Controllers\API\V1\Admin;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Models\V1\Job;

use App\Models\V1\User;

class AdminController extends AppBaseController
{
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
}
