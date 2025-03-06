<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Notifications\PasswordResetNotification;
use App\Models\User;

class ForgotController extends Controller
{
    public function index(){    //formulaire d'oubli mdp
        $data = [
            'title'=> $description = 'Oublie de mot de passe -'.config('app.name'),
            'description'=>$description,
        ];
        return view('auth.forgot', $data);
    }

    public function store() //verif des data et envoi de lien mail 
    {   
        request()->validate([
            'email'=>'required|email|exists:users',
        ]);

        $token = Str::uuid();

        DB::table('password_reset_tokens')->insert([
            'email'=>request('email'),
            'token'=>$token,
            'created_at'=>now(),
        ]);

        //envoi notif avec lien secure
        $user = User::whereEmail(request('email'))->firstOrFail();
        $user->notify(new PasswordResetNotification($token));
        $success ='Verifier votre boite mail et suivez les instructions';
        return back()->withSuccess($success);
    }
}