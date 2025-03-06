<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{
    Article,
    Category
};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Http\Requests\ArticleRequest;


class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    protected $perPage = 5;
    public function index()
    {
        $articles = Article::orderByDesc('id')->paginate($this->perPage);
        $data = [
            'title'=>'Les articles du blog -'.config('app.name'),
            'description'=>'Retrouvez tous les articles de'.config('app.name'),
            'articles'=>$articles,
        ];
        return view('article.index', $data);
    } 

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::get();

        $data = [
            'title'=>$description = 'Ajouter un nouvel article',
            'description'=>$description,
            'categories'=>$categories,
        ];
        return view('article.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ArticleRequest $request)
    {

        $validatedData = $request->validated();
        $validatedData['category_id'] = request('category', null);

        Auth::user()->articles()->create($validatedData);

        // $article = Auth::user()->articles()->create(request()->validate([
        //     'title'=>['required', 'max:20', 'unique:articles,title'],
        //     'content'=>['required'],
        //     'category'=>['sometimes', 'nullable', 'exists:categories,id'],
        // ]));

        // $article->categorie_id = request('category', null);
        // $article->save();

        // $article = Article::create([
        //     'user_id'=>Auth::id(),
        //     'title'=>request('title'),
        //     'slug'=>Str::slug(request('title')),
        //     'content'=>request('content'),
        //     'categorie_id'=>request('category', null),
        // ]);
        
        // $article = new Article;
        // $article->user_id = Auth::id();
        // $article->categorie_id = request('category', null);
        // $article->title = request('title');
        // $article->slug = Str::slug($article->title);
        // $article->content = request('content');
        // $article->save();

        $success = 'Article ajouté!';
        return back()->withSuccess($success);
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        $data = [
            'title'=>$article->title.'-'.config('app.name'),
            'description'=>$article->title.'.'.Str::words($article->content, 10),
            'article'=>$article,
            'comments'=>$article->comments()->orderByDesc('created_at')->get(),
        ];
        return view('article.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        abort_if(Auth::id() != $article->user_id, 403);

        $data = [
            'title'=> $description = 'Mise à jour de'.$article->title,
            'description'=> $description,
            'article'=>$article,
            'categories'=>Category::get(),
        ];
        return view('article.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ArticleRequest $request, Article $article)
    {
        $validatedData = $request->validated();
        $validatedData['category_id'] = request('category', null);

        $article = Auth::user()->articles()->updateOrCreate(['slug'=>$article->id], $validatedData);
        $success = 'Article modifié';
        return redirect()->route('articles.edit', ['article'=>$article->slug])->withSuccess($success);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        abort_if(Auth::id() != $article->user_id, 403);
        $article->delete();

        $success = 'Article supprimé';
        return back()->withSuccess($success);
    }
}
