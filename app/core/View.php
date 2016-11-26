<?php

namespace Core;

class View
{
    const DEFINED_TYPES = ['json', 'html'];

    static protected $template_view = 'default_view.php';

    public $type;

    public function __construct($type)
    {
        if ($this->checkType($type)) {
            $this->type = $type;
        }
        else {
            throw new \Exception('Undefined Render Type');
        }
    }

    private function checkType($type)
    {
        return in_array($type, self::DEFINED_TYPES);
    }

    /**
     * @param null $content_view
     * @param array $data
     */
    public function html($content_view = NULL, $data = [])
    {
        $content_view = $content_view ?: self::$template_view;

        if (is_array($data)) {
            extract($data);
        }
        require_once 'app/views/' . $content_view;
    }

    public function json($data = [])
    {
        return json_decode($data);
    }
}
