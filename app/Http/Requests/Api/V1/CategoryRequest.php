<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class CategoryRequest
 *
 * @package App\Http\Requests\Api\V1
 */
class CategoryRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string|unique:categories,title,' . $this->route('category'),
            'content' => 'required|string',
            'slug' => 'nullable|string|unique:categories,slug,' . $this->route('category'),
            'parent_id' => 'nullable|int|exists:categories,id',
        ];
    }
}
