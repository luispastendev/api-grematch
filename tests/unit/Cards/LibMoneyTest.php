<?php


declare(strict_types=1);

namespace App\Cards;

use CodeIgniter\Test\CIUnitTestCase;
use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Formatter\IntlMoneyFormatter;
use Money\Money;

class LibMoneyTest extends CIUnitTestCase
{
    public function testLib(): void
    {
        // $fiver = Money::MXN(500);
        // $value1 = Money::MXN(800);                // €8.00


        $money = new Money('-', new Currency('MXN'));
        ray($money)->die();


        // ray($money)->blue()->die();
        // $money3 = new Money('50050', new Currency('MXN'));
        // $money2 = $money3->add($money);
        // $currencies = new ISOCurrencies();

        // $numberFormatter = new \NumberFormatter('es_MX', \NumberFormatter::CURRENCY);
        // $moneyFormatter = new IntlMoneyFormatter($numberFormatter, $currencies);

        // ray($moneyFormatter->format($money2));

        // echo $moneyFormatter->format($money2); // outputs $1.00
        // exit;
    }
}
