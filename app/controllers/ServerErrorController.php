<?php

use Core\Controller;

class ServerErrorController extends Controller
{
    public function IndexAction($request)
    {
        $this->view->generate('500_view.php');
    }
}