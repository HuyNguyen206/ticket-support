<?php

namespace App\Enum;

enum TicketStatus: int
{
    case ACTIVE = 1;
    case COMPLETED = 2;
    case ON_HOLD = 3;
    case CANCEL = 4;
    case PENDING = 5;

    public static function values(): array
    {
        return collect(self::cases())->map(function($case) {
            return $case->value;
        })->toArray();
    }
}
