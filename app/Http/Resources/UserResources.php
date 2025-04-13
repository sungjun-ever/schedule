<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {;
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'teamId' => $this->team_id,
            'level' => $this->level,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            'deletedAt' => $this->deleted_at,
            'teamName' => $this->team ? $this->team->team_name : null,
        ];
    }
}
