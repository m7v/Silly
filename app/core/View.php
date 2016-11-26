<?php

namespace Core;

class View
{
	static protected $template_view = 'default_view.php';

    /**
     * @param null $content_view
     * @param array $data
     */
	function generate($content_view = NULL, $data = []) {
        $content_view = $content_view ?: self::$template_view;

		if(is_array($data)) {
			extract($data);
		}
		require_once 'app/views/'.$content_view;
	}
}
