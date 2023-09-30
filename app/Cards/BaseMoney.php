<?php 

declare(strict_types=1);

namespace App\Cards;

use App\Enums\Currencies;

class BaseMoney 
{
    protected $currency;

    public function __construct(string $currencyCode)
    {
        $this->currency = Currencies::get($currencyCode);
    }

    protected function prepare(float|string|int $amount, int $decimals): int
    {
        $amount = $this->sanitize($amount);
        $amount = round($amount, $decimals);

        return $this->toCents($amount, $decimals);
    }

    protected function getInstance(Money|float|string|int $number, int $decimals, string $currencyCode): Money
    {
        return $number instanceof Money ? $number : new Money($number, $decimals, $currencyCode);
    }

    private function isSameCurrency(Money $money): bool
    {
        return $money->get()['code'] === $this->currency->code();
    }

    private function toCents(float $amount, int $decimals): int
    {   
        return (int) round($amount * $this->currency->base(), $decimals);
    }

    private function sanitize(mixed $amount): float 
    {
        return (float) preg_replace('/[^0-9.]/', '', (string) $amount);
    }
}
