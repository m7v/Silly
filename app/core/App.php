<?php

namespace Core;

class App
{

    private $modelNames = [];
    private $controllerName;
    private $actionName;
    private $host;
    private $router;
    private $request;
    private $method;

    public function __construct()
    {
        $this->request = $_SERVER['REQUEST_URI'];
        $this->method = strtolower($_SERVER['REQUEST_METHOD']);
        $this->host = 'http://' . $_SERVER['HTTP_HOST'] . '/';
    }

    private function defineModel()
    {
        if ($this->modelNames) {
            foreach ($this->modelNames as $modelName) {
                $model_file = $modelName . '.php';
                $model_path = "app/models/" . $model_file;
                if (file_exists($model_path)) {
                    include "app/models/" . $model_file;
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
            include "app/controllers/" . $controller_file;
        } else {
            throw new RouterException('Missing Controller File');
        }
    }

    public function get($pattern, $controller, $model = [], $action = 'IndexAction')
    {
        Router::registerNewRoute($this->method, $pattern, $controller, $action, $model);
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
        $this->router = Router::$paths;

        if (!empty($this->router[$this->method][$this->request])) {
            $this->controllerName = $this->router[$this->method][$this->request]['controller'];
            $this->actionName = $this->router[$this->method][$this->request]['action'];
            $this->modelNames = $this->router[$this->method][$this->request]['model'];
        } else {
            throw new RouterException('Missing Route');
        }
    }

    private function process()
    {
        $controller = new $this->controllerName;
        $action = $this->actionName;

        if (method_exists($controller, $action)) {
            $controller->$action($this->request);
        } else {
            throw new RouterException("Missing Controller's Action");
        }
    }

    public function ErrorPage404()
    {
        header('HTTP/1.1 404 Not Found');
        header("Status: 404 Not Found");
        header('Location:' . $this->host . 'NotFound');
    }

    public function ErrorPage500()
    {
        header('HTTP/1.1 500 Internal Server Error');
        header("Status: 500 Internal Server Error");
        header('Location:' . $this->host . 'ServerError');
    }
}
