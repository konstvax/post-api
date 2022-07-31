<?php

namespace App\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class PostResource
 *
 * @package App\Resources\V1
 */
class PostResource extends JsonResource
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
            'category_id' => $this->category_id,
            'image' => $this->image ?? '',
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
