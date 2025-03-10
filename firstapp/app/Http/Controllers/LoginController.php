<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Test\Constraint\ResponseIsRedirected;

class LoginController extends Controller
{
    public function index(){ //formulaire de connexion
        $data = [
            'title'=> 'Login - '.config('app.name'),
            'description'=> 'Connexion é votre compte - '.config('app.name'),
        ];
            return view('auth.login', $data);
    }

    public function login(){ //traitement du formulaire de login
        request()->validate([
            'email'=>'required|email',
            'password'=>'required',
        ]);

        $remember = request()->has('remember');
        

        if (Auth::attempt(['email'=>request('email'), 'password'=>request('password')], $remember)){
            return redirect('/');
        }

        return back()->withError('Mauvais identifiants.')->withInput();

    }
}
