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
    private $paths;

    public function __construct() {
        $default_route = [
            'controller' => 'DefaultController',
            'model' => ['DefaultModel'],
            'action' => 'IndexAction'
        ];

        $this->paths = [
            'get' => [
                '/' => $default_route,
                '/404' => [
                        'controller' => 'NotFoundController',
                    ] + $default_route,
                '/500' => [
                        'controller' => 'ServerErrorController',
                    ] + $default_route
            ]
        ];
    }

    public function registerNewRoute($method, $pattern, $controller, $action = 'IndexAction', $model = []) {
        $this->paths[$method][$pattern] = [
            'controller' => $controller,
            'action' => $action,
            'model' => $model,
        ];
    }

    public function existsPath(Request $request) {
        return !empty($this->paths[$request->method][$request->uri]);
    }

    public function getController(Request $request) {
        return !empty($this->paths[$request->method][$request->uri]['controller'])
            ? $this->paths[$request->method][$request->uri]['controller']
            : FALSE;
    }

    public function getAction(Request $request) {
        return !empty($this->paths[$request->method][$request->uri]['action'])
            ? $this->paths[$request->method][$request->uri]['action']
            : FALSE;
    }

    public function getModel(Request $request) {
        return !empty($this->paths[$request->method][$request->uri]['model'])
            ? $this->paths[$request->method][$request->uri]['model']
            : FALSE;
    }

    public function getType(Request $request) {
        return !empty($this->paths[$request->method][$request->uri]['type'])
            ? $this->paths[$request->method][$request->uri]['type']
            : FALSE;
    }
}
