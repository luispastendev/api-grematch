<?php

namespace App\Cards\Money;

use CodeIgniter\Test\CIUnitTestCase;

class NumberTest extends CIUnitTestCase
{
    public function testNumberStringParse(): void
    {
        $number      = new Number('-5.e-0');
        $numberTwo   = new Number('-.5550');
        $numberThree = new Number('+.5550');

        $this->assertSame('-5.e-0',  $number->getFormattedNumber());
        $this->assertSame('-0.5550', $numberTwo->getFormattedNumber());
        $this->assertSame('0.5550',  $numberThree->getFormattedNumber());
    }

    public function testNumberFloatParse(): void
    {
        $number    = new Number(10.1234567891011121314);
        $numberTwo = new Number(10.12);

        $this->assertSame('10.12345678910111', $number->getFormattedNumber());
        $this->assertSame('10.12000000000000', $numberTwo->getFormattedNumber());
    }

    public function testNumberIntParse(): void
    {
        $number    = new Number(50000);
        $numberTwo = new Number(0);

        $this->assertSame('50000', $number->getFormattedNumber());
        $this->assertSame('0', $numberTwo->getFormattedNumber());
    }

    public function testValidNumber(): void
    {
        $number   = new Number(0);
        $validate = $this->getPrivateMethodInvoker($number, 'isValidNumberFormat');

        foreach ([
            '1', '12.12', '10.00', '10.00', '-0.1',
            '-1.0', '-1.34', '0000.9', '-0000.923',
            '+0.29', '-.010', '02.009000', '5e2',
            '500.e2', '500.01e0', '1.e2', '-5.e-0',
            '-.0e-0', '0', '000', '.0', '.00',
            '0.00', '-0.00', '-0', '-.0','0.0e2',
            '0e2', '000000.00000e2', '+.5550', '+0.2e+3', '0',
        ] as  $value) {
            $this->assertTrue($validate($value));
        }
    }

    public function testInvalidNumbers(): void
    {
        $number    = new Number(0);
        $validate  = $this->getPrivateMethodInvoker($number, 'isValidNumberFormat');
        $testCases = [
            '', '0.', '00.', '12*344!@#1234.9$8',
            '-0.', '--2', '1a', '2.0.2', '-2.0.2', '.a', 'w.a',
            'w.', '123a', '123.2a3', 'e2', '5e2e2', '5.0e2e2',
            '0e0e2', '0.00a', '1E2.3', '1E23.45',
            '1E2E3', '1.234e', '12e-3.4', 'abc123', '12.34.56',
            '12.34.56', '1e2.3', '1E2.3', '1E23.45', '1E2E3',
            '1.234e', '12e-3.4', 'abc123', '12.34.56', '-12.34.56',
            '1e2.3', 'abc', '12.34.56', '-$123.45', '1e2e3', '1.23,45',
            '1.2e-3.4', '1E0xE1', '1.23e-45E6', 'NaN', '1.2.3',
            '123456789012345678-123456', '123456789012345678+13456',
            '-123456789012345678.-13456', '+123456789012345678.+13456',
        ];

        foreach ($testCases as $case) {
            $this->assertFalse($validate($case));
        }
    }

    public function testIsNegative(): void
    {
        $this->assertTrue((new Number('-123.09'))->isNegative());
    }

    public function testGetIntegerPart(): void
    {
        $this->assertSame(
            '-123',
            (new Number('-123.09'))->getIntegerPart()
        );
    }

    public function testGetFractionalPart(): void
    {
        $this->assertSame(
            '09e-9',
            (new Number('-123.09e-9'))->getFractionalPart()
        );
    }
}
