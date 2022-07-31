<?php

namespace App\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class CategoryResource
 *
 * @package App\Resources\V1
 */
class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'slug' => $this->slug,
            'parent_id' => $this->parent_id,
            'children_categories' => count($this->children) ? $this->children : [],
            'posts' => PostCategoryResource::collection($this->posts)
        ];
    }
}
