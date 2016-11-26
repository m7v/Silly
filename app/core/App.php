<?php

namespace Core;

class App
{

    private $modelNames = [];
    private $controllerName;
    private $actionName;
    private $request;
    private $router;
    private $type;

    public function __construct()
    {
        $this->request = new Request();
        $this->router = new Router();
    }

    private function updateController(Request $request)
    {
        $this->controllerName = $this->router->getController($request);
        $this->actionName = $this->router->getAction($request);
        $this->modelNames = $this->router->getModel($request);
        $this->type = $this->router->getType($request);
    }

    public function get($pattern, $controller, $model = [], $action = 'IndexAction', $type = 'html')
    {
        $this->router->registerNewRoute($this->request->method, $pattern, $controller, $action, $model, $type);
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
        $controller = new $this->controllerName($this->type);
        $action = $this->actionName;

        if (method_exists($controller, $this->actionName)) {
            $controller->$action($this->request);
        } else {
            throw new RouterException("Missing Controller's Action");
        }
    }

    private function ErrorPage($code)
    {
        header('HTTP/1.1 '.$code.' Not Found');
        header("Status: '.$code.' Not Found");
        $this->request->uri = '/'.$code;
        $this->request->get = 'get';
        $this->updateController($this->request);
        (new $this->controllerName($this->type))->{$this->actionName}($this->request);
    }
}
