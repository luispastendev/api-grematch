<?php

declare(strict_types=1);

namespace App\Cards\Money;

use App\Cards\Enums\ExceptionMessages;

final class Number
{
    private string $integerPart;
    private string $fractionalPart;

    public function __construct(int|float|string $number)
    {
        $this->initializeNumberParts($number);
    }

    public function isNegative(): bool
    {
        return $this->integerPart[0] === '-';
    }

    public function getFractionalPart(): string
    {
        return $this->fractionalPart;
    }

    public function getIntegerPart(): string
    {
        return $this->integerPart;
    }

    public function getFormattedNumber(): string
    {
        if ($this->fractionalPart === '0') {
            return $this->integerPart;
        }

        return "{$this->integerPart}.{$this->fractionalPart}";
    }

    private function initializeNumberParts(int|float|string $number): void
    {
        if (is_int($number) || is_string($number)) {
            $number = (string) $number;
        }

        if (is_float($number)) {
            $number = (string) sprintf('%.14F', $number);
        }

        $isValid = $this->isValidNumberFormat($number);

        if (! $isValid) {
            $exception = ExceptionMessages::get('INVALID_ARGUMENT');

            throw new \InvalidArgumentException(
                $exception->message($number),
                $exception->code()
            );
        }

        [
            $this->integerPart,
            $this->fractionalPart,
        ] = $this->splitNumber($number);
    }

    private function splitNumber(string $number): array
    {
        [
            $integerPart,
            $fractionalPart,
        ] = array_pad(explode('.', $number, 2), 2, '0');

        if ($integerPart === '-') {
            $integerPart = '-0';
        }

        if ($integerPart === '+' || $integerPart === '') {
            $integerPart = '0';
        }

        return [
            $integerPart,
            $fractionalPart,
        ];
    }

    private function isValidNumberFormat(string $number): bool
    {
        preg_match('/^[-+]?(?:\d+)?(?:\.\d+)?(?:(?:\.?\d+|\d+\.\d+|\d+\.)[eE][-+]?\d+)?$/', $number, $matches);

        $match = $matches[0] ?? '';

        return strlen($match) > 0;
    }
}
