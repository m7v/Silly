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
        $this->router = new Router($this->request);
    }

    private function defineModel()
    {
        if ($this->modelNames) {
            foreach ($this->modelNames as $modelName) {
                $model_file = $modelName . '.php';
                $model_path = "app/models/" . $model_file;
                if (file_exists($model_path)) {
                    require_once "app/models/" . $model_file;
                } else {
                    throw new RouterException('Missing Model File');
                }
            }
        }
    }

    private function defineController()
    {
        $controller_file = $this->controllerName . '.php';
        $controller_path = "app/controllers/" . $controller_file;
        if (file_exists($controller_path)) {
            require_once "app/controllers/" . $controller_file;
        } else {
            throw new RouterException('Missing Controller File');
        }
    }

    public function get($pattern, $controller, $model = [], $action = 'IndexAction', $type = 'html')
    {
        $this->router->registerNewRoute($this->request->method, $pattern, $controller, $action, $model, $type);
    }

    public function run()
    {
        try {
            $this->buildRoute();
            $this->defineModel();
            $this->defineController();
            $this->process();
        } catch (RouterException $e) {
            $this->ErrorPage404();
        } catch (\Exception $e) {
            $this->ErrorPage500();
        }
    }

    private function buildRoute()
    {
        if (!empty($this->router->existsPath())) {
            $this->controllerName = $this->router->getController();
            $this->actionName = $this->router->getAction();
            $this->modelNames = $this->router->getModel();
            $this->type = $this->router->getType();
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

    private function ErrorPage404()
    {
        header('HTTP/1.1 404 Not Found');
        header("Status: 404 Not Found");
        header('Location:' . $this->request->host . '404');
    }

    private function ErrorPage500()
    {
        header('HTTP/1.1 500 Internal Server Error');
        header("Status: 500 Internal Server Error");
        header('Location:' . $this->request->host . '500');
    }
}
