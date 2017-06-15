<?php

    namespace Core;


    class Request
    {
        public $uri;
        public $get;
        public $post;

        public function __construct()
        {
            $path = explode('?', $_SERVER['REQUEST_URI']);
            $this->uri = $path[0];
            $this->get = $_GET;
            $this->post = $_POST;
            $this->host = 'http://' . $_SERVER['HTTP_HOST'] . '/';
            $this->method = strtolower($_SERVER['REQUEST_METHOD']);
        }
    }