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
                
                <div class="card mt-4">

                    <div class="card-body">
                        <h1 class="card-title">{{ $article->title }}</h1>
                        <p class="card-text"> {{$article->content}}</p>
                            
                        <span class="author">Par <a href="{{route('user.profile', ['user'=>$article->user->id])}}">{{ $article->user->name }}</a> inscrit le {{$article->user->created_at->format('d/m/Y')}}</span><br>
                        <span class="time"> Posté {{$article->created_at->diffForHumans()}} </span>
                    </div>
                </div>

            <div class="card card-outline-secondary my-4">
                <div class="card-header">
                    Commentaires
                </div>
                <div class="class-body">
                    @forelse($comments as $comment)
                    <p> {{$comment->content }}</p>
                    <small class="text-muted"><a href="{{route ('user.profile', ['user'=>$comment->user->id])}}"> {{$comment->user->name}}</a> le {{$comment->created_at->isoFormat('LL') }}</small>
                    <hr>
                    @empty
                    
                    @endforelse
                        <p>Pas de commentaire pour l'instant</p>
                    @auth
                    <form action="{{route ('post.comment', ['article'=>$article->slug])}}" method="post">

                        @csrf 

                          <div class="form-group">
                            <label for="content">Laisser un commentaire</label>
                            <textarea class="form-control" name="content" cols="30" rows="5" placeholder="Votre commentaire">{{old('content')}}</textarea>
                            @error('content')
                                <div class="error"> {{$message}}</div>
                            @enderror
                          </div>

                        <button type="submit" class="btn btn-primary">Commenter</button>
                      </form>
                    @endauth
                    @guest
                    <a href="{{route('login')}}" class="btn btn-success">Laisser un commentaire</a>
                    @endguest

                </div>
            </div>
            </div>
        </div>
@stop