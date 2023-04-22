<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{

    //Home redirect

    public function Home()
    {
        $userType = Auth::user()->user_type;

        if ($userType === '2ru') {

            return view('backend.home');
        } else {

            return view('frontend.home');
        }
    }


    //register route
    public function Register()
    {

        return view('frontend.register');
    }

    //addAdmin to DB
    public function AddUser(Request $request)
    {
        //validate user form
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string',
            'password' => 'required|string|min:8',
            'confirm_password' => 'required_with:password|same:password|min:8|string'
        ]);

        //Checks if the user already exist b4 adding to the database
        $email =  User::where('email', $request->email)->exists();

        if ($email) {
            // Alert::error('Email Already Exist');
            return redirect()->back();
        } else {

            $data  = new User();

            $data->name = $request->name;
            $data->email = $request->email;
            $data->password = Hash::make($request->password);

            $data->save();

            // Alert::success('Admin Created Successfully');
            return redirect()->back();
        }
    }
}