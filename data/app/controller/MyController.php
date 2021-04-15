<?php
namespace app\controller;

use support\bootstrap\db\Dbal;
use support\Request;

class MyController
{
    public function index(Request $request)
    {
        extract($request->get());

        $response = [
            'status'   => 200,
            'response' => 'success',
        ];

        return json($response);
    }
}
