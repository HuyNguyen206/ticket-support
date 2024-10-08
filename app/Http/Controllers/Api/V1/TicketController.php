<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Filters\V1\TicketFilter;
use App\Http\Requests\Api\V1\ReplaceTicketRequest;
use App\Http\Requests\Api\V1\StoreTicketRequest;
use App\Http\Requests\Api\V1\UpdateTicketRequest;
use App\Http\Resources\V1\TicketResource;
use App\Models\Ticket;
use App\Policies\V1\TicketPolicy;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TicketController extends ApiController
{
    public string $policyClass = TicketPolicy::class;

    /**
     * Get all tickets.
     *
     * @group Managing tickets
     *
     * @queryParam sort string Data field(s) to sort by. Separate by multiple fields with comma. Denote descending sort with a minus sign
     * @example: filter[include] = user
     */
    public function index(Request $request, TicketFilter $ticketFilter)
    {
        $queryBuilder = Ticket::filter($ticketFilter);

        return $this->success(data: TicketResource::collection($queryBuilder->paginate())->resource);
    }

    /**
     * Create a new Ticket.
     *
     * Users can only create ticket for themselves. Manager can create ticket for any user
     * @group Managing tickets
     */
    public function store(StoreTicketRequest $request)
    {
        $this->isAbleTo('create', Ticket::class);

        $data = $request->validated();

        return $this->success(data: TicketResource::make(Ticket::create(data_get($data, 'data.attributes') + ['user_id' => $request->user()->id])), statusCode: Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket, Request $request)
    {
        if ($this->include('user')) {
            $ticket->load('user');
        }

        return new TicketResource($ticket);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTicketRequest $request, Ticket $ticket)
    {
        $data = $request->validated();

        $ticket->update(data_get($data, 'data.attributes')
        + (data_get($data, 'data.relationships.user.id') ? ['user_id' => data_get($data, 'data.relationships.user.id')] : []));

        return $this->success(data: $ticket);
    }

    /**
     * Replace the specified resource in storage.
     */
    public function replace(ReplaceTicketRequest $request, Ticket $ticket)
    {
        $data = $request->validated();

        $ticket->update(data_get($data, 'data.attributes') + ['user_id' => data_get($data, 'data.relationships.user.id')]);

        return $this->success(data: $ticket);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        try {
            $ticket = Ticket::findOrFail($id);
            $ticket->delete();
        } catch (ModelNotFoundException $exception) {
            return $this->error('Ticket not found', statusCode: Response::HTTP_NOT_FOUND);
        }

        return $this->success(statusCode: Response::HTTP_NO_CONTENT);
    }
}
