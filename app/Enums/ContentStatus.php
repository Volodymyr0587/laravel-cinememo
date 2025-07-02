<?php

namespace App\Enums;

enum ContentStatus: string
{
    case Watching = 'watching';
    case Watched = 'watched';
    case WillWatch = 'willwatch';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function labels(): array
    {
        return [
            self::Watching->value => 'Watching',
            self::Watched->value => 'Watched',
            self::WillWatch->value => 'Will Watch',
        ];
    }
}
