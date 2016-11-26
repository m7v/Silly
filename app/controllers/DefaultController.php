<?php

use Core\Controller;
use Core\Request;

class DefaultController extends Controller
{
    function __construct($type)
    {
        parent::__construct($type);
        $this->model = new DefaultModel();
    }

    public function IndexAction(Request $request)
	{
		$this->view->{$this->view->type}('default_view.php', $this->model->getData());
	}
}