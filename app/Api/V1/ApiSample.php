<?php

namespace App\API\V1;

use CodeIgniter\RESTful\ResourceController;

class ApiSample extends ResourceController
{

    protected $format = 'json';

    public function index()
    {
        return $this->respond([
            'msg' => 'hello world'
        ]);
    }
}
