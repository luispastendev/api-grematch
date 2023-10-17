<?php

declare(strict_types=1);

namespace App\Cards\Enums;

enum ExceptionMessages
{
    case INVALID_ARGUMENTS;
    case INVALID_ARGUMENT;

    public static function get(string $code): self
    {
        return constant("self::{$code}");
    }

    public function message(mixed ...$params): string
    {
        return match ($this) {
            self::INVALID_ARGUMENTS => vsprintf('number %s has invalid characters, -> %s found.', $params), 
            self::INVALID_ARGUMENT  => vsprintf('number %s not is a valid number.', $params), 
        };
    }

    public function code(): int
    {
        return match ($this) {
            self::INVALID_ARGUMENTS => 1,
            self::INVALID_ARGUMENT => 2,
        };
    }

}
