<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Filters\V1\TicketFilter;
use App\Http\Requests\Api\V1\StoreTicketRequest;
use App\Http\Resources\V1\TicketResource;
use App\Models\Ticket;
use App\Models\User;

class UserTicketsController extends ApiController
{
    public function index(User $user, TicketFilter $ticketFilter)
    {
        return $this->success(data: TicketResource::collection(Ticket::query()->whereBelongsTo($user)->filter($ticketFilter)->paginate())->resource);
    }

    public function store(User $user, StoreTicketRequest $request)
    {
        $data = $request->validated();

        return TicketResource::make($user->tickets()->create(data_get($data, 'data.attributes')));
    }
}
