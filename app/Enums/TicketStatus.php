<?php

namespace App\Enums;

enum TicketStatus: string
{
    case Open = 'open';
    case Waiting = 'waiting';
    case Closed = 'closed';

    /**
     * @return array<string>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
