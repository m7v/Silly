<?php

use Core\Controller;
use Core\Request;

class DefaultController extends Controller
{
    function __construct()
    {
        parent::__construct();
        $this->model = new DefaultModel();
    }

    public function IndexAction(Request $request)
	{
		$this->view->generate(
		    $request,
            'default_view.php',
            $this->model->getData()
        );
	}
}