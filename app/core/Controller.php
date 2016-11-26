<?php

namespace Core;

abstract class Controller {
	
	public $model;
	public $view;

	function __construct()
	{
	    $this->model = new \DefaultModel();
		$this->view = new View();
	}
	
	public function IndexAction($request) {}
}
