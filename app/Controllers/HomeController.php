<?php

namespace Controllers;

use Solovey\Routing\Controller;

class HomeController extends Controller
{
	function index()
	{
		$this->render('home');
	}

}