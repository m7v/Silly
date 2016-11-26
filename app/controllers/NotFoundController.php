<?php

use Core\Controller;
use Core\Request;

class NotFoundController extends Controller
{
    public function IndexAction(Request $request)
	{
		$this->view->{$this->view->type}('404_view.php');
	}
}
