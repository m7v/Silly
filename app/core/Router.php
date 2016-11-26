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
    const DEFAULT_ROUTE = [
        'controller' => 'DefaultController',
        'model' => ['DefaultModel'],
        'action' => 'IndexAction'
    ];

    static public $paths = [
        'get' => [
            '/' => self::DEFAULT_ROUTE,
            '/NotFound' => self::DEFAULT_ROUTE + [
                'controller' => 'NotFoundController',
            ],
            '/ServerError' => self::DEFAULT_ROUTE + [
                'controller' => 'ServerErrorController',
            ]
        ]
    ];

    static public function registerNewRoute($method, $pattern, $controller, $action = 'IndexAction', $model = []) {
        self::$paths[$method][$pattern] = [
            'controller' => $controller,
            'action' => $action,
            'model' => $model,
        ];
    }
}

