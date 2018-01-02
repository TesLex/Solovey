<?php

use Solovey\Routing\Controller;

class HomeController extends Controller
{

	function main()
	{
		$this->render('home');
	}

}