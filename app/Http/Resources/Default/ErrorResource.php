<?php

namespace App\Http\Resources\Default;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ErrorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'error' => $this['error'],
            'message' => $this['message']
        ];
    }

    public function withResponse($request, $response)
    {
        $response->setStatusCode($this['code']);
    }
}
