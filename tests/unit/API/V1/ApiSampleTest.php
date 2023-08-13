<?php

namespace App\API\V1;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;

class ApiSampleTest extends CIUnitTestCase
{
    use FeatureTestTrait;

    public function testSampleApi()
    {
        $response = $this->get('/api');

        $response->assertOK();
        $response->assertHeader('Content-Type', 'application/json; charset=UTF-8');
    }
}
