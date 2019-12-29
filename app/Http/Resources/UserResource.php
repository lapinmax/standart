<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource {
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray ($request) {
        return [
            "id" => $this->id,
            "email" => $this->email,
            "gender" => $this->gender,
            "favoriteColor" => $this->favoriteColor,
            "favoriteNumber" => $this->favoriteNumber,
            "socialType" => $this->socialType,
            "token" => $this->socialToken,
            "profileID" => $this->socialProfileID,
            "type" => $this->type,
            "active" => $this->active,
            "timeBirth" => $this->time_birth,
            "placeBirth" => $this->place_birth,
            "birthday" => is_null($this->birthday) ? null : $this->birthday->format('d.m.Y'),
            "created_at" => $this->created_at->format('d.m.Y H:i:s'),
            "updated_at" => $this->updated_at->format('d.m.Y H:i:s'),
        ];
    }
}
