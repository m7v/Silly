<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 26.11.16
 * Time: 21:48
 */

namespace Core;


class Response
{
    private $body;
    private $headers = [];

    public function setHeaders($headers) {
        $this->headers[] = $headers;
    }

    public function setBody($body) {
        $this->body = $body;
    }

    public function render() {
        foreach ($this->headers as $header) {
            header($header);
        }
        echo $this->body;
    }
}