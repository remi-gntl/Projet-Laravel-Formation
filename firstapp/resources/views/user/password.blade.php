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
                        Modifier mon mot de passe              
                </div>
                <div class="class-body">
                    
                    <form action="{{route ('update.password')}}" method="post">

                        @csrf
                        
                        <div class="mb-3">
                            <label for="current">Mot de passe actuel</label>
                            <input type="password" name="current" class="form-control">
                            @error('current')
                                <div class="error"> {{$message}}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password">Nouveau mot de passe</label>
                            <input type="password" name="password" class="form-control">
                            @error('password')
                                <div class="error"> {{$message}}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation">Confirmer le mot de passe</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>

                        <button type="submit" class="btn btn-primary">Modifier</button>
                      </form>

                      <p class="mt-5"><a href="{{route ('user.edit')}}">Revenir a mon compte</a></p>
                </div>
            </div>

        </div>