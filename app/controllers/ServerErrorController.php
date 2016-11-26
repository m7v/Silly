<?php

use Core\Controller;
use Core\Request;

class ServerErrorController extends Controller
{
    public function IndexAction(Request $request)
    {
        $this->view->generate(
            $request,
            '500_view.php',
            ["code" => 500, "status" => "InternalServerError"]
        );
    }
}