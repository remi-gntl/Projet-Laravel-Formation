<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title'=> $this->method() == 'POST' ?
            ['required', 'max:20', 'unique:articles,title'] :
            ['required', 'max:20', Rule::unique('articles', 'title')->ignore($this->article)],
            'content'=>['required'],
            'category'=>['sometimes', 'nullable', 'exists:category,id'],
        ];
    }

    public function messages()
    {
        return [
            'title.required'=>'Chef il manque un titre la',
            'content.required'=>'Et ici? Ca va se faire tout seul tu penses?',
        ];
    }
}
