<?php

declare(strict_types=1);

namespace App\Cards;

final class Money extends BaseMoney
{
    private string $currencyCode = '';
    private string $symbol       = '';
    private int    $decimals     = 0;
    private int    $amount       = 0;
    private int    $base         = 0;

    public function __construct(mixed $amount, int $decimals = 2, string $currencyCode = 'MXN')
    {
        parent::__construct($currencyCode);

        $this->currencyCode = $this->currency->code();
        $this->base         = $this->currency->base();
        $this->symbol       = $this->currency->symbol();
        $this->decimals     = $decimals;
        $this->amount       = $this->prepare($amount, $decimals);
    }

    public function get(): array
    {
        return [
            'number' => $this->amount,
            'money'  => $this->format(),
            'symbol' => $this->symbol,
            'code'   => $this->currencyCode,
            'base'   => $this->base,
        ];
    }

    public function number(): float|int
    {
        $number = round($this->amount / $this->base, $this->decimals);

        return $number == 0 ? 0 : $number;
    }

    public function cents(): int
    {
        return $this->amount;
    }

    public function format(): string
    {
        return $this->symbol . number_format($this->number(), $this->decimals);
    }
}
