<?php

use core\Controller;

class ErrorPageController extends Controller
{
	
	function action404()
	{
		$this->view->generate('view_404');
	}

}
