<?php


declare(strict_types=1);

namespace App\Enums;

use CodeIgniter\Test\CIUnitTestCase;
use App\Enums\Currencies;

class CurrenciesTest extends CIUnitTestCase
{
    protected $currency;

    protected function setUp(): void
    {
        $this->currency = Currencies::get('MXN');
    }

    public function testSymbol(): void
    {
        $this->assertEquals('$', $this->currency->symbol());
    }

    public function testCode(): void
    {
        $this->assertEquals('MXN', $this->currency->code());
    }

    public function testBase(): void
    {
        $this->assertEquals(100, $this->currency->base());
    }

    public function testGet(): void
    {
        $this->assertInstanceOf(Currencies::class, $this->currency);
    }
}
