<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 26.11.16
 * Time: 21:48
 */

namespace Core;


class Request
{
    public $uri;
    public $get;
    public $post;

    public function __construct()
    {
        $this->uri = $_SERVER['REQUEST_URI'];
        $this->get = $_GET;
        $this->post = $_POST;
        $this->host = 'http://' . $_SERVER['HTTP_HOST'] . '/';
        $this->method = strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function getInstance() {
        return $this;
    }
}