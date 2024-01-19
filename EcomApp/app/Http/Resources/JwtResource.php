<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JwtResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'token' => $this->resource,
            'tokenType' => 'bearer',
            'expiresIn' => auth('api')->factory()->getTTL() * 60 * 24,
        ];
    }
}
