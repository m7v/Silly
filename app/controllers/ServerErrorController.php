<?php

use Core\Controller;
use Core\Request;

class ServerErrorController extends Controller
{
    public function IndexAction(Request $request)
    {
        $this->view->html('500_view.php');
    }
}