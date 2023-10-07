<?php

declare(strict_types=1);

namespace App\Cards;

use CodeIgniter\Test\CIUnitTestCase;

class MoneyTest extends CIUnitTestCase
{
    protected $money;

    protected function setUp(): void
    {
        // $money = new Money('$1,100.54');
    }

    public function testConstructor(): void
    {
        $money_string          = new Money('100.10');
        $money_float           = new Money(100.20);
        $money_float_round     = new Money(100.205);
        $money_int             = new Money(100);
        $money_string_comma    = new Money('1,100.40');
        $money_symbol          = new Money('$1,100.50');
        $money_symbol_no_round = new Money('$1,100.54');

        $this->assertSame(10010,  $this->getPrivateProperty($money_string, 'amount'));
        $this->assertSame(10020,  $this->getPrivateProperty($money_float, 'amount'));
        $this->assertSame(10021,  $this->getPrivateProperty($money_float_round, 'amount'));
        $this->assertSame(10000,  $this->getPrivateProperty($money_int, 'amount'));
        $this->assertSame(110040, $this->getPrivateProperty($money_string_comma, 'amount'));
        $this->assertSame(110050, $this->getPrivateProperty($money_symbol, 'amount'));
        $this->assertSame(110054, $this->getPrivateProperty($money_symbol_no_round, 'amount'));
    }

    public function testMoneyGet(): void
    {
        // $money = new Money('$1,100.54');

        // var_dump($money->get());
        // todo
    }

    public function testGetNumber(): void
    {
        $money_string       = new Money('$1,100.54');
        $money_string_round = new Money('$1,100.545');
        $money_float        = new Money(1100.54);
        $money_int          = new Money(100);
        $money_float_cents  = new Money(0.015);

        $this->assertSame(1100.54, $money_string->number());
        $this->assertSame(1100.55, $money_string_round->number());
        $this->assertSame(1100.54, $money_float->number());
        $this->assertSame(100.00, $money_int->number());
        $this->assertSame(0.02, $money_float_cents->number());
    }

    public function testGetCents(): void
    {
        $money = new Money('$1,100.54');

        $this->assertSame(110054, $money->cents());
    }

    public function testMoneyFormat(): void
    {
        $money_float_cents        = new Money(0.015);
        $money_with_currency_code = new Money('$102,300.54 MXN');

        $this->assertSame('$0.02', $money_float_cents->format());
        $this->assertSame('$102,300.54', $money_with_currency_code->format());
    }

    public function testOperationNotValid(): void
    {
        $money = new Money(0.015);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('not valid operation.');
        $money->divide(0);
    }

    public function testOperationSubtract(): void
    {
        $money_zero     = new Money(1);
        $money_sub      = new Money('$200.00');
        $money_negative = new Money('$200.00');

        $this->assertSame(199.00, $money_sub->sub(1)->number());
        $this->assertSame(0, $money_zero->sub(1)->number());
        $this->assertSame(-1.21, $money_negative->sub(201.205)->number());
    }

    public function testOperationMultiply(): void
    {
        $money = new Money('$200.00');

        $this->assertSame(1240.00, $money->multiply(3.1)->multiply(2)->number());
    }

    public function testOperationAdd(): void
    {
        $money = new Money(0.015);

        $this->assertSame(901.02, $money->add(1)->add('900.00')->number());
    }

    public function testDivideWithPrimitives(): void
    {
        $money = new Money('$1,100.54');

        $this->assertSame(45.86, $money->divide(12)->divide(2)->number());
    }

    public function testDivideWithMoneyObject(): void
    {
        $money = new Money('$1,100.54');

        $this->assertSame(10.77, $money->divide(new Money('$102.23'))->number());
    }



    // public function testAdd()
    // {
    //     $money_1 = new Money('$1,100.54');
    //     $money_2 = new Money(9894.29);
    //     $installments = 12;
    //     $result_1 = $money_1->divide($installments);
    //     $result_2 = $money_2->divide($installments);

    //     $this->assertSame(91.71, $result_1->number());
    //     $this->assertSame(824.52, $result_2->number());
    //     $this->assertInstanceOf(Money::class, $result_1);
    //     $this->assertInstanceOf(Money::class, $result_2);
    // }
}
