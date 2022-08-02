<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class PostRequest
 *
 * @package App\Http\Requests\Api\V1
 */
class PostRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string|unique:posts,title,' . $this->route('post'),
            'content' => 'required|string',
            'slug' => 'nullable|string|unique:posts,slug,' . $this->route('post'),
            'image' => 'nullable|image|max:2048',
            'category_id' => 'required|int|exists:categories,id',
        ];
    }
}
