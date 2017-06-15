<?php

    use Core\Controller;
    use Core\Request;
    use Core\Response;

    class DefaultController extends Controller
    {
        function __construct()
        {
            parent::__construct();
            $this->model = new DefaultModel();
        }

        public function IndexAction(Request $request, Response $response)
        {
            $this->view->generate(
                $request,
                $response,
                'default_view',
                $this->model->getData()
            );
        }
    }