@extends('layouts.main')
@section('content')

<div class="row">

            <div class="col-lg-3">
                @include('includes.sidebar')
            </div>

            <div class="col-lg-9">

                @if(session('success'))
                <div class="alert alert-success">{{session('success')}}</div>
                @endif


            <div class="card card-outline-secondary my-4">
                <div class="card-header">
                        Bonjour {{$user->name}}              
                </div>
                <div class="class-body">
                    
                    <form action="{{route('post.user') }}" method="post" enctype="multipart/form-data">

                        @csrf
                        <div class="mb-3">
                            <label for="name">Nom d'utilisateur</label>
                            <input type="text" name="name" class="form-control" value="{{old('name', $user->name)}}">
                            @error('name')
                                <div class="error"> {{$message}}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control" value="{{old('email', $user->email)}}">
                            @error('email')
                                <div class="error"> {{$message}}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                        <label for="avatar">Avatar</label>
                        <input type="file" name="avatar">
                        </div>

                        @if(!empty($user->avatar->filename))
                        <div class="mb-2">   
                            <a href="{{ $user->avatar->url}}" target="blank">
                                <img src="{{ $user->avatar->thumb_url }}" width="200" height="200">
                            </a>
                        </div>
                        @endif

                        <button type="submit" class="btn btn-primary">Envoyer</button>
                      </form>

                      <p class="mt-5"><a href="{{route ('user.password')}}">Modifier mon mot de passe</a></p>

                      <div class="text-right">
                        <form action="{{ route('user.destroy', ['user'=>$user->id]) }}" method="post">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="alert-danger">Supprimer</button>
                        </form>
                      </div>
                </div>
            </div>

        </div>