<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource {
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray ($request) {
        return [
            "id" => $this->id,
            "text" => $this->message,
            "type" => $this->type,
            "created_at" => $this->created_at->format('d.m.Y H:i:s'),
            "updated_at" => $this->updated_at->format('d.m.Y H:i:s'),
        ];
    }
}
