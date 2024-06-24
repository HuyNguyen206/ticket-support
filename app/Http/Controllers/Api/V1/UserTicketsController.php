<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Filters\V1\TicketFilter;
use App\Http\Resources\V1\TicketResource;
use App\Models\Ticket;
use App\Models\User;
use App\Traits\ApiResponse;

class UserTicketsController extends Controller
{
    use ApiResponse;

    public function index(User $user, TicketFilter $ticketFilter)
    {
        return $this->success(data: TicketResource::collection(Ticket::query()->whereBelongsTo($user)->filter($ticketFilter)->paginate())->resource);
    }
}
