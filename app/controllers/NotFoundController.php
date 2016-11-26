<?php

use Core\Controller;

class NotFoundController extends Controller
{
    public function IndexAction($request)
	{
		$this->view->generate('404_view.php');
	}
}
