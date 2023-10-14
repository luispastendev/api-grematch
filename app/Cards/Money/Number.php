<?php

declare(strict_types=1);

namespace App\Cards\Money;

use App\Cards\Enums\ExceptionMessages;

final class Number
{
    public function parse(string $number): mixed
    {
        $this->check($number);



        return $number;
        // $amount = round($amount, $decimals);

        // return $this->toCents($amount, $decimals);
        // return sprintf('%.14F', $number);
        // return true;
    }

    private function validNumber(string $number)
    {
        preg_match('/^-?(?!0*\.?(0+)?$)(\d+\.?(\d+)?|\.\d+)$/', $number, $matches);

        $match = $matches[0] ?? '';

        return strlen($match) > 0;
    }

    /**
     * validate correct format number
     */
    private function validFormat(string $number): void
    {
        preg_match_all('/[^0-9\.]/', $number, $matches);
        $invalidChars = implode('', $matches[0]);

        if (strlen($invalidChars) > 0) {
            $exception = ExceptionMessages::get('INVALID_ARGUMENTS');

            throw new \InvalidArgumentException(
                $exception->message($number, $invalidChars),
                $exception->code()
            );
        }
    }
}
