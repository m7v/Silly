<?php

    namespace Core;

    class Router
    {
        private $paths;

        public function __construct() {
            $default_route = [
                'controller' => 'DefaultController',
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

        public function registerNewRoute($method, $pattern, $controller, $action = 'IndexAction') {
            $this->paths[$method][$pattern] = [
                'controller' => $controller,
                'action' => $action,
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
    }
