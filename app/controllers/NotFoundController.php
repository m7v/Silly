<?php

use Core\Controller;
use Core\Request;
use Core\Response;

class NotFoundController extends Controller
{
    public function IndexAction(Request $request, Response $response)
	{
		$this->view->generate(
		    $request,
            $response,
            '404_view',
            ["code" => 404, "status" => "NotFound"]
        );
	}
}
