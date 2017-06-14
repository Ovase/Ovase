<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
//use Symfony\Component\Config\Definition\Exception\Exception;

class HomeController extends Controller
{
  
	public function showHomeAction()
	{
		return $this->render('home/index.html.twig');
	}
}
