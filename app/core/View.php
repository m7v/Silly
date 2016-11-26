<?php

namespace Core;

class View
{
    const DEFINED_TYPES = ['json', 'html'];

    static protected $template_view = 'default_view.php';

    public $type;

    public function checkType($type)
    {
        return in_array($type, self::DEFINED_TYPES);
    }

    public function generate(Request $request, $content_view, $data = []) {
        if ($this->checkType($request->get['_format'])) {
            $this->{$request->get['_format']}($data);
        }
        else {
            $this->html($content_view, $data);
        }
    }

    public function html($content_view = NULL, $data = [])
    {
        $content_view = $content_view ?: self::$template_view;

        if (is_array($data)) {
            extract($data);
        }
        header('Content-Type: text/html; charset=UTF-8');
        require_once 'app/views/' . $content_view;
    }

    public function json($data = [])
    {
        header('Content-Type: application/json');
        print json_encode($data);
    }
}
