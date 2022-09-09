<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\Inscription;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Notifications\UserRegisterNotification;

class UserController extends Controller
{
    //Show Register/Create Form
    public function create(){
        return view('users.register');
    }

    //Create New User
    public function store(Request $request){
        $formFields = $request->validate([
            'name'=>['required','min:3'],
            'email'=>['required','email',Rule::unique('users','email')],
            'password'=>['required','confirmed','min:6'],
        ]);

        //Hache password
        $formFields['password'] = bcrypt($formFields['password']);

        //Create User
        $user = User::create($formFields);

        /* //mail
        Mail::to($user->email)->send(new Inscription()); */

        //notification
        //$user->notify(new UserRegisterNotification($user));

        //Login
        auth()->login($user);

        return redirect('/')->with('message','users created and logged in');
    }

    //Logout User
    public function logout(Request $request){

        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('message','You have been logged out');
    }

    //Show Login Form
    public function login(){
        return view('users.login');
    }

    //Log User In 
    public function authenticate(Request $request){
        $formFields = $request->validate([
            'email'=>['required'],
            'password'=>['required'],
        ]);

        if(auth()->attempt($formFields)){
            $request->session()->regenerate();
            

            return redirect('/')->with('message','You are now logged in!');
        }

        return back()->withErrors(['email'=>'Invalid Credentials'])->onlyInput('email');
    }

}
