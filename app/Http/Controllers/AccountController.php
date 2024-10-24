<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function registration(){

        return view('front.account.registration');
    }

    public function processRegistration(Request $request){
        
        $validator = Validator::make($request->all(),[
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:5',
            'confirm_password' => 'required|same:password'
        ]);

        if($validator->passes()){

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();

            session()->flash('success','You have successfully registered.');
            return response()->json([
                'status' => true,
                'message' => 'You have successfully registered.',
            ]);


        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }
    }

    public function login(){

        return view('front.account.login');
    }

    public function authienticate(Request $request){

        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if($validator->passes()){

            if(Auth::attempt(['email' => $request->email,'password' => $request->password])){
                return redirect()->route('account.profile');
            }
            else{
                return redirect()->route('account.login')->with('error','Either Email/Password is invalid');    
            }

        }else{
            return redirect()->route('account.login')
            ->withErrors($validator)
            ->withInput($request->only('email'));
        }

    }

    public function profile(){

        $id = Auth::user()->id;
        $user = User::find($id);
        return view('front.account.profile',[
            'user' => $user
        ]);

    }

    public function updateProfile(Request $request){

        $id = Auth::user()->id;

        $validator = Validator::make($request->all(),[
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email,'.$id.',id',
        ]);

        if($validator->passes()){

            $user = User::find($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->mobile = $request->mobile;
            $user->designation = $request->designation;
            $user->save();

            session()->flash('success','Profile Updated Successfully');

            return response()->json([
                'status' => true,
                'message' => 'Profile Updated Successfully',
            ]);

        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('account.login');
    }
}
