<?php

namespace AppBundle\Controller;

use AppBundle\Form\ProjectSearchForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ProjectListController extends Controller
{
	public function projectListAction(Request $request)
	{
		$searchTerm = '';
		$form = $this -> createForm(ProjectSearchForm::class);
		$form -> handleRequest($request);

		if($form->isSubmitted() && $form->isValid()){
			$searchTerm = $form->getData()['search'];
		}

		$projects = $this->get('doctrine')
			->getRepository('AppBundle:Project')
			->findProjectsBySearch($searchTerm);

		return $this->render(
			'project/projectList.html.twig', array(
				'projects' => $projects,
				'form' => $form->createView())
		);
	}
}
