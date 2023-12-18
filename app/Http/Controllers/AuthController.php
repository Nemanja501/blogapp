<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Mail\VerifyMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showLogin(){
        return view('pages.auth.login');
    }

    public function showRegister(){
        return view('pages.auth.register');
    }

    public function verifyEmail(string $id){
        $user = User::find($id);
        $current_date_time = Carbon::now()->toDateTimeString();
        $user->email_verified_at = $current_date_time;
        $user->save();
        return redirect('/login')->with('status', 'Verified email!');
    }

    public function store(RegisterRequest $request){
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        
        $userId = $user->id;
        Mail::to($user->email)->send(new VerifyMail($userId));
        
        return redirect('/login')->with('status', 'Successfully created account!');
    }

    public function index(LoginRequest $request){
        if(Auth::check()){
            return redirect('/login')->withErrors('You are already logged in!');
        }

        $credentials = $request->only('email', 'password');
        if(!Auth::attempt($credentials)){
            return redirect('/login')->withErrors('Invalid credentials!');
        }

        
        if(Auth::user()->email_verified_at == NULL){
            return $this->destroy('Email not verified!');
        }

        return redirect('/')->with('status', 'Login success!');
    }

    public function destroy($message = 'Logged out'){
        Session::flush();
        Auth::logout();

        return redirect('/login')->with('status', $message);
    }
}
