<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Filters\V1\TicketFilter;
use App\Http\Requests\Api\V1\ReplaceTicketRequest;
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

        return TicketResource::make($request->user()->tickets()->create(data_get($data, 'data.attributes')));
    }

    /**
     * Replace the specified resource in storage.
     */
    public function replace(ReplaceTicketRequest $request, User $user, int $id)
    {
        $ticket = $user->tickets()->find($id);

        if ($ticket) {
            $data = $request->validated();
            $ticket->update(data_get($data, 'data.attributes') + ['user_id' => data_get($data, 'data.relationships.user.id')]);

            return $this->success($ticket);
        }

        return $this->error('Ticket not found', statusCode: 404);
    }

    public function destroy(User $user, int $id)
    {
        $ticket = $user->tickets()->find($id);

        if ($ticket) {
            $ticket->delete();
            return $this->success(statusCode: 204);
        }

        return $this->error('Ticket not found', statusCode: 404);
    }
}
