<?php

namespace Core;

abstract class Controller {
	
	public $model;
	public $view;

	function __construct($type)
	{
	    $this->model = new Model();
		$this->view = new View($type);
	}

	public function IndexAction(Request $request) {}
}
