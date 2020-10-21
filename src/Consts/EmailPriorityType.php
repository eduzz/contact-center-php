<?php 

namespace Eduzz\ContactCenter\Consts;

class EmailPriorityType {
    const HIGH   = 'high';
    const MEDIUM = 'medium';
    const LOW    = 'low';

    public static function getTypes(): array
    {
        return [
            self::HIGH,
            self::MEDIUM,
            self::LOW
        ];
    }
}
