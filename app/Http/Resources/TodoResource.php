<?php

namespace App\Http\Resources;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TodoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'content' => $this->content,
            'is_complete' => $this->is_complete,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            // 'created_by' => $this->created_by,
        ];
    }
}