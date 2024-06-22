<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;

class TicketResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return ['type' => 'ticket'] +
            [
                'attributes' => parent::toArray($request) + $this->only(['title', 'status'])
                    + ['description' => $this->when($request->routeIs('tickets.show'), $this->description)]
//                    ($request->routeIs('tickets.show') ? $this->only(['description']) : [])
            ] +
            [
                'links' => ['self' => route('tickets.show', $this->id)]
            ] +
            [
                'relationships' => ['user' => new UserResource($this->user)]
            ];
    }
}
