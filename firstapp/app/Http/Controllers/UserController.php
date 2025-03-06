<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;


use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function profile(User $user)
    {
        return'Je suis un utilisateur aka '.$user->name;
    }

    public function edit()  //formulaire de mise à jour des infos du user connecté
    {
        $user = Auth::user();
        $data = [
            'title'=>$description = 'Editer mon profil',
            'description'=>$description,
            'user'=>$user,
        ];
        return view('user.edit', $data);
    }


    public function password()
    {
        $data = [
            'title' =>$description = 'Modifier mon mot de passe',
            'description'=>$description, 
            'user'=>Auth::user(),
        ];
        return view('user.password', $data);
    }

    public function updatePassword() //maj du mdp
    {
        request()->validate([
            'current'=>'required|current_password',
            'password'=>'required|between:9,26|confirmed',
        ]);

        $user = Auth::user();
        $user->password = bcrypt(request('password'));
        $user->save();
        $success = 'Mot de passe mis à jour';

        return back()->withSuccess($success);
    }


    public function store() //sauvegarde des infos
    {
        $user = Auth::user();

        DB::beginTransaction();

        try
        {
            $user = User::updateOrCreate(['id'=>$user->id],
        request()->validate([
            'name'=>['required', 'min:3', 'max:20', Rule::unique('users')->ignore($user)],
            'email'=>['required', 'email', Rule::unique('users')->ignore($user)],
            'avatar'=>['sometimes', 'nullable', 'file', 'image', 'mimes:jpeg, png'],
        ]));

        if(request()->hasFile('avatar') && request()->file('avatar')->isValid()){

            if(Storage::exists('avatars/'.$user->id))
            {
                Storage::delete('avatars/'.$user->id);
            }

            $ext = request()->file('avatar')->extension();
            $filename = Str::slug($user->name).'-'.$user->id.'.'.$ext;
            $path = request()->file('avatar')->storeAs('avatars/'.$user->id, $filename);

            $thumbnailImage = Image::make(request()->file('avatar'))->fit(200,200, function($constraint){
                $constraint->upsize();
            })->save(public_path($ext,50));

            $thumbnailPath = 'avatars/'.$user->id.'/thumbnail/'.$filename;

            Storage::put($thumbnailPath, $thumbnailImage);

            $user->avatar()->updateOrCreate(['user_id'=>$user->id],
            [
                'filename'=>$filename,
                'url'=>Storage::url($path),
                'path'=>$path,
                'thumb_url'=>Storage::url($thumbnailPath),
                'thumb_path'=>$thumbnailPath,
            ]
        );
        }
        }

        catch(ValidationException $e){
            DB::rollBack();
        }
        DB::commit();

        $success = 'Informations mise à jour.';
        return back()->withSuccess($success);
    }

    public function destroy(User $user) //suppression compte utilisateur
    { 
        abort_if($user->id != auth()->id(), 403);
        Storage::deleteDirectory('avatars/'.$user->id);
        $user->delete();

        $success = 'Utilisateur supprimé';
        return redirect('/')->withSuccess($success);
    }
}

 