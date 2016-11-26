<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 26.11.16
 * Time: 20:33
 */

namespace Core;

class Router
{
    private $request;

    private $paths;

    public function __construct(Request $request) {
        $this->request = $request;

        $default_route = [
            'controller' => 'DefaultController',
            'model' => ['DefaultModel'],
            'action' => 'IndexAction',
            'type' => 'html'
        ];

        $this->paths = [
            'get' => [
                '/' => $default_route,
                '/404' => $default_route + [
                        'controller' => 'NotFoundController',
                    ],
                '/500' => $default_route + [
                        'controller' => 'ServerErrorController',
                    ]
            ]
        ];
    }

    public function registerNewRoute($method, $pattern, $controller, $action = 'IndexAction', $model = [], $type = 'html') {
        $this->paths[$method][$pattern] = [
            'controller' => $controller,
            'action' => $action,
            'model' => $model,
            'type' => $type,
        ];
    }

    public function existsPath() {
        return !empty($this->paths[$this->request->method][$this->request->uri]);
    }

    public function getController() {
        return !empty($this->paths[$this->request->method][$this->request->uri]['controller'])
            ? $this->paths[$this->request->method][$this->request->uri]['controller']
            : FALSE;
    }

    public function getAction() {
        return !empty($this->paths[$this->request->method][$this->request->uri]['action'])
            ? $this->paths[$this->request->method][$this->request->uri]['action']
            : FALSE;
    }

    public function getModel() {
        return !empty($this->paths[$this->request->method][$this->request->uri]['model'])
            ? $this->paths[$this->request->method][$this->request->uri]['model']
            : FALSE;
    }

    public function getType() {
        return !empty($this->paths[$this->request->method][$this->request->uri]['type'])
            ? $this->paths[$this->request->method][$this->request->uri]['type']
            : FALSE;
    }
}
