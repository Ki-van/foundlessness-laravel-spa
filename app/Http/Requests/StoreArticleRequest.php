<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreArticleRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'heading' => 'required|max:255',
            'description' => 'required|min:20|max:511|unique:App\Models\Article',
            'body' => 'required',
            'domain_id' => 'required|exists:domains,id',
            'tag_ids' => 'nullable|array',
            'tag_ids.*' => 'exists:tags, id'
        ];
    }
}
