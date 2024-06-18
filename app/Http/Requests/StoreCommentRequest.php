<?php

namespace App\Http\Requests;

use App\Entities\Comment;
use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'post_id' => ['required', 'exists:posts,id'],
            'content' => ['required', 'string'],
            'abbreviation' => ['required', 'string', 'unique:comments,abbreviation'],
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'abbreviation' => (new Comment($this->get('content', '')))->getAbbreviation(),
        ]);
    }

    public function messages(): array
    {
        return [
            'abbreviation.required' => 'Unable to generate abbreviation using empty content.',
            'abbreviation.unique' => 'The abbreviation generated for the specified content already exists.',
        ];
    }
}
