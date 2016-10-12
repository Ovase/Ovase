<?php

namespace AppBundle\Controller;


use AppBundle\Form\SearchForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ProjectListController extends Controller
{
	public function projectListAction(Request $request)
	{
		$projects = $this->get('doctrine')
			->getRepository('AppBundle:Project')
			->findAll();

		return $this->render(
			'project/projectList.html.twig', array(
				'projects' => $projects
			)
		);
	}
}