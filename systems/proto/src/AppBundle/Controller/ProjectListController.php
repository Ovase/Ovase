<?php

namespace AppBundle\Controller;

use AppBundle\Form\ProjectSearchForm;
use AppBundle\Form\ProjectFilteringForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ProjectListController extends Controller
{
	public function projectListAction(Request $request)
	{
		$searchTerm = '';
		$searchMeasures = null;
		$searchFunctions = null;
		$searchForm = $this -> createForm(ProjectSearchForm::class);
		$searchForm->handleRequest($request);
		if ($searchForm->isSubmitted() && $searchForm->isValid()) {
			$searchTerm = $searchForm->getData()['search'];
			$searchMeasures = $searchForm->getData()['measureTypes'];
			$searchFunctions = $searchForm->getData()['measureFunctions'];
		}

		$projectRepo = $this->get('doctrine')->getRepository('AppBundle:Project');
		$textSearchProjects = 
			$projectRepo->findProjectsByTextSearch($searchTerm);

		$filteredProjects =
			$projectRepo->filterProjects($textSearchProjects, array(
				'measureTypes' => $searchMeasures,
				'measureFunctions' => $searchFunctions,
				));

		return $this->render(
			'project/projectList.html.twig', array(
				'projects' => $filteredProjects,
				'form' => $searchForm->createView())
		);
	}

	// This is intended to be a separate "advanced search" page
	public function advancedProjectListAction(Request $request)
	{
		$searchTerm = '';
		$searchMeasures = null;
		$searchFunctions = null;
		$searchForm = $this -> createForm(ProjectSearchForm::class);
		$searchForm->handleRequest($request);
		if ($searchForm->isSubmitted() && $searchForm->isValid()) {
			$searchTerm = $searchForm->getData()['search'];
			$searchMeasures = $searchForm->getData()['measureTypes'];
			$searchFunctions = $searchForm->getData()['measureFunctions'];
		}

		$projectRepo = $this->get('doctrine')->getRepository('AppBundle:Project');
		$textSearchProjects = 
			$projectRepo->findProjectsByTextSearch($searchTerm);

		$filteredProjects =
			$projectRepo->filterProjects($textSearchProjects, array(
				'measureTypes' => $searchMeasures,
				'measureFunctions' => $searchFunctions,
				));

		return $this->render(
			'project/projectListAdvanced.html.twig', array(
				'projects' => $filteredProjects,
				'form' => $searchForm->createView())
		);
	}
}
