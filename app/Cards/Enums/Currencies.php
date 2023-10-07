<?php

declare(strict_types=1);

namespace App\Cards\Enums;

enum Currencies
{
    case MXN;
    case USD;

    public static function get(string $code): self
    {
        return constant("self::{$code}");
    }

    public function symbol(): string
    {
        return match ($this) {
            self::MXN,
            self::USD => '$',
        };
    }

    public function code(): string
    {
        return match ($this) {
            self::MXN => 'MXN',
            self::USD => 'USD',
        };
    }

    public function base(): int
    {
        return match ($this) {
            self::MXN,
            self::USD => 100,
        };
    }
}
