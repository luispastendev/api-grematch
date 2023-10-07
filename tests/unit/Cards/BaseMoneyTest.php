<?php

declare(strict_types=1);

namespace App\Enums;

use App\Cards\{BaseMoney, Money};
use CodeIgniter\Test\CIUnitTestCase;

class BaseMoneyTest extends CIUnitTestCase
{
    private BaseMoney $class;

    protected function setUp(): void
    {
        parent::setUp();
        $this->class = new BaseMoney('MXN');
    }

    public function testPrepareNumber(): void
    {
        $prepare = $this->getPrivateMethodInvoker($this->class, 'prepare');

        $this->assertSame(110061, $prepare('$1,100.605', 2));
        $this->assertSame(110066, $prepare('$1,100.66', 2));
        $this->assertSame(110066, $prepare('$1,100.663', 2));
        $this->assertSame(110067, $prepare('$1,100.666', 2));
        $this->assertSame(67, $prepare('0.665', 2));
        $this->assertSame(167, $prepare('1.665', 2));
    }

    public function testCantPerformOperationDivideZero(): void
    {
        $money               = new Money(0);
        $canPerformOperation = $this->getPrivateMethodInvoker($this->class, 'canPerformOperation');

        $this->assertFalse($canPerformOperation($money, 'divide'));
    }

    public function testCantPerformOperationOperationNotFound(): void
    {
        $money               = new Money(100);
        $canPerformOperation = $this->getPrivateMethodInvoker($this->class, 'canPerformOperation');

        $this->assertFalse($canPerformOperation($money, 'Divaides'));
    }

    public function testCantPerformOperationNotSameCurrencies(): void
    {
        $money               = new Money(100, 2, 'USD');
        $canPerformOperation = $this->getPrivateMethodInvoker($this->class, 'canPerformOperation');

        $this->assertFalse($canPerformOperation($money, 'divide'));
    }

    public function testCanPerformOperation(): void
    {
        $money               = new Money(100);
        $canPerformOperation = $this->getPrivateMethodInvoker($this->class, 'canPerformOperation');

        $this->assertTrue($canPerformOperation($money, 'divide'));
    }

    public function testGenerateInstanceWithPrimitives(): void
    {
        $getInstance = $this->getPrivateMethodInvoker($this->class, 'getInstance');

        $this->assertInstanceOf(Money::class, $getInstance(10000.24, 2, 'MXN'));
    }

    public function testGenerateInstanceWithInstance(): void
    {
        $getInstance = $this->getPrivateMethodInvoker($this->class, 'getInstance');
        $money       = new Money(100);

        $this->assertInstanceOf(Money::class, $getInstance($money, 2, 'MXN'));
    }

    public function testItSameCurrency(): void
    {
        $money       = new Money(100, 2, 'USD');
        $getInstance = $this->getPrivateMethodInvoker($money, 'isSameCurrency');

        $this->assertTrue($getInstance(new Money(200, 2, 'USD')));
    }

    public function testToCents(): void
    {
        $toCents = $this->getPrivateMethodInvoker($this->class, 'toCents');

        $this->assertSame(167, $toCents('1.67', 2));
        // $this->assertSame(, $toCents('0.019', 2));
    }

    public function testSanitize(): void
    {
        $sanitize = $this->getPrivateMethodInvoker($this->class, 'sanitize');

        $this->assertSame(1100.666, $sanitize('$1,100.666 MXN'));
    }
}
