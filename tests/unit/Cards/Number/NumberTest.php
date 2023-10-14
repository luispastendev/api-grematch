<?php

namespace App\Cards\Money;

use CodeIgniter\Test\CIUnitTestCase;
use stdClass;

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
        $number = new Number();
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
            '02.009000'
        ] as  $value) {
            $this->assertTrue($validNumber($value));
        }
    }

    public function testNotValidNumbers(): void
    {
        $number = new Number();
        $validNumber = $this->getPrivateMethodInvoker($number, 'validNumber');
        foreach ([
            '0', '000', '0.', '00.',
            '.0', '.00', '0.00', '-0.00',
            '-0', '-.0', '-0.', '--2',
            '1a', '0.00a', '2.0.2', '-2.0.2',
            '.a', 'w.a', 'w.', '123a', '123.2a3',
        ] as $number) {
            $this->assertFalse($validNumber($number));
        }
    }

    public function testRemoveStartEndZeros(): void 
    {
        
    }
}
