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
                
                @foreach($articles as $article)
                <div class="card mt-4">

                    <div class="card-body">
                        <h2 class="card-title"><a href="{{ route('articles.show', ['article'=>$article->slug])}}">{{ $article->title }}</a></h2>
                        <p class="card-text"> {{Str::limit($article->content, 50)}}</p>
                            
                        <span class="author">Par <a href="{{route('user.profile', ['user'=>$article->user->id])}}">{{ $article->user->name }}</a> inscrit le {{$article->user->created_at->format('d/m/Y')}}</span><br>
                        <span class="time"> Posté {{$article->created_at->diffForHumans()}} </span>

                        @if(Auth::check() && Auth::user()->id == $article->user_id)
                        <div class="author mt-4">
                            <a href="{{route('articles.edit', ['article'=>$article->slug])}}" class="btn btn-info">Modifier</a>&nbsp;
                            <form style="display: inline;"  action="{{route('articles.destroy', ['article'=>$article->slug])}}" method="post">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="btn btn-danger">X</button>
                            </form>
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach

                {{--Pagination--}}
                <div class="pagination mt-5">
                    {{$articles->links()}}
                </div>

            {{--<div class="card card-outline-secondary my-4">
                <div class="card-header">
                    Commentaires
                </div>
                <div class="class-body">
                    <p> jofezjfjzpodezkopafdj poopfezjfo pjzef jzoepfjefjgkrez
                        fko pjfpe jzpr jfo"ejkf fjeo
                        f zend_logo_guidf er. </p>
                    <small class="text-muted">Jean le 26 Fevrier à 12h36</small>
                    <hr>

                    <p> fez ef fzejfhezjfhozehfuzei hhf zdf hizdhf zend_logo_guidff
                        fezgefgefg efg efgdg fgetcefgrt
                        gregregegegg.</p>
                    <small class="text-muted">Paul le 27 Fevrier à 13h36</small>
                    <hr>

                    <a href="#" class="btn btn-success">Laisser un commentaire</a>
                </div>
            </div>--}}
            </div>
        </div>
@stop