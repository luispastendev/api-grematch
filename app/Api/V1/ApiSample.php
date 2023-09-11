<?php

namespace App\API\V1;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class ApiSample extends BaseController
{

    use ResponseTrait;

    public function index()
    {
        return $this->respond([
            'msg' => 'hello world'
        ]);
    }
    
    public function protected() 
    {

        return $this->respond([
            'msg' => 'Accesando al endpoint!'
        ]);
    }
}
