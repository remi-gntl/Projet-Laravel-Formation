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
                    Ajouter un article
                </div>
                <div class="class-body">
                    
                    <form action="{{route('articles.store') }}" method="post">

                        @csrf
                        <div class="mb-3">
                            <label for="title" class="form-label">Titre </label>
                            <input type="text" name="title" class="form-control" value="{{old('title')}}">
                            @error('title')
                                <div class="error"> {{$message}}</div>
                            @enderror
                          </div>

                          <div class="form-group">
                            <label for="content">Contenu</label>
                            <textarea class="form-control" name="content" cols="30" rows="5" placeholder="Contenu de l'article">{{old('content')}}</textarea>
                            @error('content')
                                <div class="error"> {{$message}}</div>
                            @enderror
                          </div>
                          
                          <div  class="form-group">
                            <label for="category">Catégorie</label>
                            <select class="form-control" name="category">
                                <option value=""></option>
                                @foreach($categories as $category)
                                <option value="{{$category->id}}" @if(old('category') == $category->id) selected @endif>{{$category->name}}</option>
                                @endforeach
                            </select>
                            @error('category')
                                <div class="error"> {{$message}}</div>
                            @enderror
                          </div>

                        <button type="submit" class="btn btn-primary">Ajouter</button>
                      </form>
                </div>
            </div>

        </div>