<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UserResource;
class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return[
            "id"=>$this->id,
            "body"=> $this->body,
            "created_at"=> $this->created_at->diffForHumans(),
            "updated_at"=> $this->updated_at,
            "user"=> new UserResource($this->user),
            "comments"=> CommentResource::collection($this->comments),
        ];
    }
}
