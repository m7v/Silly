<?php

namespace Core;

class App
{

    private $controllerName;
    private $actionName;
    private $request;
    private $response;
    private $router;

    public function __construct()
    {
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router();
    }

    private function updateController(Request $request)
    {
        $this->controllerName = $this->router->getController($request);
        $this->actionName = $this->router->getAction($request);
    }

    public function get($pattern, $controller, $action = 'IndexAction')
    {
        $this->router->registerNewRoute($this->request->method, $pattern, $controller, $action);
    }

    public function run()
    {
        try {
            $this->buildRoute();
            $this->process();
        } catch (RouterException $e) {
            $this->ErrorPage(404);
        } catch (\Exception $e) {
            $this->ErrorPage(500);
        }
        $this->response->render();
    }

    private function buildRoute()
    {
        if (!empty($this->router->existsPath($this->request))) {
            $this->updateController($this->request);
        } else {
            throw new RouterException('Missing Route');
        }
    }

    private function process()
    {
        $controller = new $this->controllerName();
        $action = $this->actionName;

        if (method_exists($controller, $this->actionName)) {
            $controller->$action($this->request, $this->response);
        } else {
            throw new RouterException("Missing Controller's Action");
        }
    }

    private function ErrorPage($code)
    {
        $this->response->setHeaders('HTTP/1.1 '.$code.' Not Found');
        $this->response->setHeaders('Status: '.$code.' Not Found');
        $this->request->uri = '/'.$code;
        $this->request->method = 'get';
        $this->updateController($this->request);
        (new $this->controllerName())->{$this->actionName}($this->request, $this->response);
    }
}
