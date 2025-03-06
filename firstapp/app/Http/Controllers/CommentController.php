<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Models\{
    Comment,
    Article
};
use App\Http\Requests\CommentRequest;

class CommentController extends Controller
{
    public function store(CommentRequest $request, Article $article)
    {
        $validatedData = $request->validated();
        $validatedData['user_id'] = Auth::id();

        $article->comments()->create($validatedData);

        $success = 'commentaire ajouté';

        return back()->withSuccess($success);
    }
}
