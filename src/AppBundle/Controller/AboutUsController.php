<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AboutUsController extends Controller
{
	public function showAction(Request $request)
	{
		return $this->render(
			'home/aboutus.html.twig'
		);
	}
}