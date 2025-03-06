<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class ResetController extends Controller
{
    public function index(string $token)  //formulaire de réinitialisation de mdp
    {
        $password_reset = DB::table('password_reset_tokens')->where('token', $token)->first();

        abort(!$password_reset, 403);

        $data = [
            'title' => $description = 'reinitialisation de mot de passe - '.config('app.name'),
            'description'=>$description,
            'password_reset'=>$password_reset,
        ];
        return view('auth.reset', $data);
    }


    public function reset() //traitement initialisation du mdp
    {
        request()->validate([
            'email'=>'required|email',
            'token'=>'required',
            'password'=>'required|between:9,20|confirmed',
        ]);

        if(!DB::table('password_reset_tokens')
            ->where('email', request('email'))
            ->where('token', request('token'))->count()
        ){
            $error = 'Verifiez l\'adresse email.';
            return back()->withError($error)->withInput();
        }

        $user = user::whereEmail(request('email'))->firstOrFail();

        $user->password = bcrypt(request('password'));
        $user->save();

        DB::table('password_reset_tokens')->where('email', request('email'))->delete();
        
        $success = 'Mot de passe changé avec succes';
        return redirect()->route('login')->withSuccess($success);
    }
}
