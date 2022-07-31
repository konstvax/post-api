<?php

namespace App\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class PostCategoryResource
 *
 * @package App\Resources\V1
 */
class PostCategoryResource extends JsonResource
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
            'slug' => $this->slug,
            'category_id' => $this->category_id,
        ];
    }
}
