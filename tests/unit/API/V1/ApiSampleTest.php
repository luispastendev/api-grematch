<?php

namespace App\Api\v1;

use CodeIgniter\Shield\Models\UserModel;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;

class ApiSampleTest extends CIUnitTestCase
{
    use FeatureTestTrait;
    use DatabaseTestTrait;

    protected $migrate     = true;
    protected $migrateOnce = false;
    protected $refresh     = true;
    protected $namespace   = [
        'CodeIgniter\Shield',
        'CodeIgniter\Settings',
    ];

    public function testSampleApi(): void
    {
        $user  = fake(UserModel::class);
        $token = $user->generateAccessToken('foo');

        $response = $this->withHeaders([
            'Authorization' => "Bearer {$token->raw_token}",
        ])->get('/v1');

        $response->assertStatus(200);
        $response->assertSee('hello world');
    }
}
