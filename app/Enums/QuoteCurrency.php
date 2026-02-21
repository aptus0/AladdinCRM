<?php

namespace App\Enums;

enum QuoteCurrency: string
{
    case Try = 'TRY';
    case Usd = 'USD';
    case Eur = 'EUR';

    /**
     * @return array<string>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
