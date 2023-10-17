<?php

declare(strict_types=1);

namespace App\Cards\Money;

use App\Cards\Enums\ExceptionMessages;
use Exception;
use InvalidArgumentException;

final class Number
{
    private $integerPart;
    private $fractionalPart;

    // public function __construct($number)
    // {
    //     $this->validate($number);
    // }
    public function __invoke($number)
    {
        $this->parse($number);
    }

    public function parse(int|float|string $number): mixed
    {
        if (is_int($number) || is_string($number)) {
            $number = (string) $number;
        }

        if (is_float($number)) {
            $number = (string) sprintf('%.14F', $number);
        }

        return $this->makeNumber($number);
    }

    private function makeNumber($number) 
    {
        $this->validate($number);
        $this->generateNumberParts($number);
    }

    private function validate(string $number): void
    {
        preg_match('/^[-+]?(?:\d+)?(?:\.\d+)?(?:(?:\.?\d+|\d+\.\d+|\d+\.)[eE][-+]?\d+)?$/', $number, $matches);

        $match = $matches[0] ?? '';

        if (strlen($match) <= 0) {
            $exception = ExceptionMessages::get('INVALID_ARGUMENT');

            throw new \InvalidArgumentException(
                $exception->message($number),
                $exception->code()
            );
        }
    }

    private function generateNumberParts(string $number)
    {
        if ($number == 0) {
            $this->integerPart = 0;
            $this->fractionalPart = 0;
        }

        $numbers = explode('.', $number);

        ray($numbers)->die();
    }
}
