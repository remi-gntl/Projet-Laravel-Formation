@extends('layouts.main')
@section('content')

<div class="row">

            <div class="col-lg-3">
                @include('includes.sidebar')
            </div>

            <div class="col-lg-9">

                    <h1 class="text-muted">{{ $category->name}}</h1>


                    @forelse($articles as $article)
                    <div class="card mt-4">

                        <div class="card-body">
                            <h2 class="card-title"><a href="{{ route('articles.show', ['article'=>$article->slug]) }}"> {{ $article->title }}</a></h2>

                            <p class="card-text"> {{Str::words($article->content, 5) }}</p>

                            <span class="author">Par<a href="{{ route('user.profile', ['user'=>$article->user->id]) }}">{{ $article->user->name }}</a>
                                inscrit le {{ $article->user->created_at->format('d/m/Y') }}</span> <br>
                            <span class="time">Posté {{$article->created_at->diffForHumans() }}</span>

                            <div class="text-right">{{ $article->comments_count }} Commentaire(s)</div>

                            @if(Auth::check() && Auth::user()->id == $article->user_id)
                            <div class="author mt-4">
                                <a href="{{route('articles.edit', ['article'=>$article->slug]) }}" class="btn btn-info">Modifier</a>
                                &nbsp;
                                <form style="display: inline;" action="{{ route('articles.destroy', ['article'=>$article->slug]) }}" method="post">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="btn btn-danger"> X</button>
                                </form>
                            </div>
                        @endif

                    </div>
                    </div>
                    @empty

                    <div class="card mt-4">

                        <div class="card-body">
                            <p>Aucun Article</p>
                        </div>
                    </div>

                    @endforelse


                    <div class="pagination mt-5">
                        {{ $articles->links() }}
                    </div>
            </div>
</div>
@stop