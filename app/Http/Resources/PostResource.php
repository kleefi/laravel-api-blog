<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "title" => $this->title,
            "body" => $this->body,
            "category" => $this->category->title,
            "author" => [
                "name" => $this->user->name,
                "email" => $this->user->email,
            ]
        ];
    }
    public function with(Request $request): array
    {
        return [
            'meta' => [
                'api_version' => '1.0',
                'generated_at' => now()->toIso8601String(),
            ]
        ];
    }
}
