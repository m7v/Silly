<?php

use Core\Controller;
use Core\Request;
use Core\Response;

class ServerErrorController extends Controller
{
    public function IndexAction(Request $request, Response $response)
    {
        $this->view->generate(
            $request,
            $response,
            '500_view',
            ["code" => 500, "status" => "InternalServerError"]
        );
    }
}