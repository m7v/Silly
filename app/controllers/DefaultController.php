<?php

use Core\Controller;

class DefaultController extends Controller
{
    public function IndexAction($request)
	{
		$this->view->generate('default_view.php', $this->model->getData());
	}
}