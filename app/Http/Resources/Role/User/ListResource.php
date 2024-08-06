<?php

namespace App\Http\Resources\Role\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'roles' => $this['roles'],
        ];
    }

    public function withResponse($request, $response)
    {
        $response->setStatusCode(200);
    }
}
