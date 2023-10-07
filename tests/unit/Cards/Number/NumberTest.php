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

        $check = $this->getPrivateMethodInvoker($number, 'check');
        $check($testNum);
    }

    public function testNumberFloatParse(): void
    {
        $number = new Number();

        $check = $this->getPrivateMethodInvoker($number, 'check');
        $this->assertEmpty($check(100.23));
    }

    public function testNumberIntParse(): void
    {
        $number = new Number();

        $check = $this->getPrivateMethodInvoker($number, 'check');
        $this->assertEmpty($check(123));
    }
}
