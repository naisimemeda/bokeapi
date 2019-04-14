<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'name' => $this->name,
            'status' => $this->status,
            'topics_id' => $this->topics_id,
            'name_id' => $this->name_id,
            'created_at'=>(string)$this->created_at,
            'updated_at'=>(string)$this->updated_at
        ];
    }
}
