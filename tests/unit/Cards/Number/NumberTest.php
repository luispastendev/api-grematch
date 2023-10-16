<?php

namespace App\Cards\Money;

use CodeIgniter\Test\CIUnitTestCase;

class NumberTest extends CIUnitTestCase
{
    public function testNumberHasSymbolsParse(): void
    {
        $number = new Number();

        $testNum = '12*344!@#1234.9$8';

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("number {$testNum} has invalid characters, -> *!@#$ found.");

        $validFormat = $this->getPrivateMethodInvoker($number, 'validFormat');
        $validFormat($testNum);
    }

    public function testNumberFloatParse(): void
    {
        $number = new Number();

        $validFormat = $this->getPrivateMethodInvoker($number, 'validFormat');
        $this->assertEmpty($validFormat(100.23));
    }

    public function testNumberIntParse(): void
    {
        $number = new Number();

        $validFormat = $this->getPrivateMethodInvoker($number, 'validFormat');
        $this->assertEmpty($validFormat(123));
    }

    public function testValidNumber(): void
    {
        $number      = new Number();
        $validNumber = $this->getPrivateMethodInvoker($number, 'validNumber');
        foreach ([
            '1',
            '12.12',
            '10.00',
            '10.00',
            '-0.1',
            '-1.0',
            '-1.34',
            '0000.9',
            '-0000.923',
            '0.29',
            '-.010',
            '02.009000',
            '5e2',
            '500.e2',
            '500.01e0',
            '1.e2',
            '-5.e-0',
            '-.0e-0',
            '0', '000', '.0', '.00', '0.00', '-0.00',
            '-0', '-.0','0.0e2','0e2', '000000.00000e2',
        ] as  $value) {
            $this->assertTrue($validNumber($value));
        }
    }

    public function testNotValidNumbers(): void
    {
        $number      = new Number();
        $validNumber = $this->getPrivateMethodInvoker($number, 'validNumber');
        foreach ([
            '0.', '00.',
            '-0.', '--2',
            '1a', '2.0.2', '-2.0.2',
            '.a', 'w.a', 'w.', '123a', '123.2a3',
            'e2', '5e2e2', '5.0e2e2',
            '0e0e2', '0.00a',
            '1E2.3', '1E23.45','1E2E3', '1.234e',
            '12e-3.4', 'abc123', '12.34.56', '12.34.56',
            '1e2.3', '1E2.3', '1E23.45', '1E2E3', '1.234e',
            '12e-3.4', 'abc123', '12.34.56', '-12.34.56', '1e2.3',
            'abc', '12.34.56', '-$123.45', '1e2e3', '1.23,45',
            '1.2e-3.4', '1E0xE1', '1.23e-45E6', 'NaN', '1.2.3',
        ] as $number) {
            $this->assertFalse($validNumber($number));
        }
    }

    public function testParseNumber(): void
    {
        $number = new Number("-98");
    }
}
