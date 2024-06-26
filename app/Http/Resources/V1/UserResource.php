<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;

class UserResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
      public function toArray(Request $request): array
      {
          return parent::toArray($request) +
              $this->only(['name', 'email']) + [
                  $this->mergeWhen($request->routeIs('users.*'), $this->only(['email_verified_at', 'remember_token']))
              ] + [ 'tickets' => TicketResource::collection($this->whenLoaded('tickets'))];
      }
}
