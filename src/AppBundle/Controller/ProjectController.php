<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Project;
use AppBundle\Form\CreateProjectForm;
use AppBundle\Form\ProjectType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Ivory\GoogleMap\Map;

class ProjectController extends Controller
{
	public function showAction(Request $request)
	{
		$requestID = $request->get('id');
		//$map = new Map(); // don't forget to render
		$project = $this->getDoctrine()->getManager()->getRepository('AppBundle:Project')->find($requestID);

		return $this->render('project/project.html.twig', array('project' => $project));
	}

	public function createAction(Request $request)
	{
		$project = new Project();
		$form = $this->createForm(ProjectType::class, $project);
		$form->handleRequest($request);
		if($form->isValid()){
			$this->getDoctrine()->getManager()->getRepository('AppBundle:Project')->create($project);
			return $this->redirect('/anlegg');
		}
		return $this->render(
			'project/create.html.twig', array(
				'form' => $form -> createView()
			)
		);
	}
}
