<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Exception;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

class LinkedinController extends Controller
{
    public function linkedinRedirect(){

        $response = Socialite::driver('linkedin')->scopes(['r_liteprofile', 'r_emailaddress'])->redirect();
        // echo "<pre"; print_r($response); die;
        return $response;
    }
    

    public function linkedinCallback(){
        try {
            \Log::info(request()->all());
            $user = Socialite::driver('linkedin')->user();
      
            $linkedinUser = User::where('oauth_id', $user->id)->first();
            // echo "<pre>"; print_r($user); die;
            if($linkedinUser){
      
                Auth::login($linkedinUser);
     
                return redirect('/dashboard');
      
            }else{
                $user = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'oauth_id' => $user->id,
                    'oauth_type' => 'linkedin',
                    'password' => encrypt('Admin@123')
                ]);
     
                Auth::login($user);
      
                return redirect('/dashboard');
            }
     
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
