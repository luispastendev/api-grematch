<?php

namespace App\Api\v1;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

final class ApiSample extends BaseController
{

    use ResponseTrait;

    public function index()
    {
        return $this->respond([
            'msg' => 'hello world'
        ]);
    }
}
