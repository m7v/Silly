<?php

namespace Core;

class View
{
    const DEFINED_TYPES = ['json', 'html'];

    private $templates;

    public $type;

    static protected $template_view = 'default_view';

    public function __construct()
    {
        $this->templates = 'app/views/';
    }

    public function checkType($type)
    {
        return in_array($type, self::DEFINED_TYPES);
    }

    public function render($content_view, $values) {
        $file = $this->templates . $content_view . '.php';
        if (!file_exists($file)) {
            throw new \Exception("Error loading template file ($file).");
        }
        $output = file_get_contents($file);

        foreach ($values as $key => $value) {
            $tagToReplace = "[@$key]";
            $output = str_replace($tagToReplace, $value, $output);
        }

        return $output;
    }

    public function generate(Request $request, Response $response, $content_view, $data = []) {
        if (!empty($request->get['_format']) && !empty($this->checkType($request->get['_format']))) {
            $this->{$request->get['_format']}($response, $data);
        }
        else {
            $content_view = $content_view ?: self::$template_view;
            $body = $this->render($content_view, $data);
            $this->html($response, $body);
        }
    }

    public function html(Response $response, $body)
    {
        $response->setHeaders('Content-Type: text/html; charset=UTF-8');
        $response->setBody($body);
    }

    public function json(Response $response, $data = [])
    {
        $response->setHeaders('Content-Type: application/json');
        $response->setBody(json_encode($data));
    }
}
