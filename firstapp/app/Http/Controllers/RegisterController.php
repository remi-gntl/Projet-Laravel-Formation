<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use GrahamCampbell\ResultType\Success;

class RegisterController extends Controller
{
    public function index()
    {
        $data =[
            'title'=>'Inscription- '.config('app.name'),
            'description'=>'Inscription sur le site'.config('app.name'),
        ];

        return view('auth.register', $data);
    }


    public function register(Request $request) //traitement formulaire d'inscription
    {
        request()->validate([
            'name'=>'required|min:3|max:20|unique:users',
            'email'=>'required|email|unique:users',
            'password'=>'required|between:9,20',
        ]);

        $user = new User;
        $user->name = request('name');
        $user->email = request('email');
        $user->password = bcrypt(request('password'));

        $user->save();

        $success = 'Inscription terminée';

        return back()->withSuccess($success);
    }
}
