<?php

use Core\Controller;
use Core\Request;

class NotFoundController extends Controller
{
    public function IndexAction(Request $request)
	{
		$this->view->generate(
		    $request,
            '404_view.php',
            ["code" => 404, "status" => "NotFound"]
        );
	}
}
