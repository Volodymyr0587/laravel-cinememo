<?php

namespace App\Enums;

enum ContentStatus: string
{
    case Watching = 'watching';
    case Watched = 'watched';
    case WillWatch = 'willwatch';
    case Waiting = 'waiting';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function labels(): array
    {
        return [
            self::Watching->value => __('content_items/status-labels.watching'),
            self::Watched->value =>  __('content_items/status-labels.watched'),
            self::WillWatch->value =>  __('content_items/status-labels.will_watch'),
            self::Waiting->value => __('content_items/status-labels.waiting'),
        ];
    }
}
