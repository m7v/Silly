<?php

use Core\Model;

class DefaultModel extends Model
{
    /**
     * @return array
     */
	public function getData()
	{	
		return [
            'title' => 'Welcome',
            'greeting' => 'Hello, Developer',
		];
	}

}
