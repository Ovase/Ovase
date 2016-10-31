<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class EditListController extends Controller
{
  
	public function showAction()
	{
		/* // To be fixed
		if(!$this->get('security.authorization_checker')->isGranted('ROLE_EDITOR'))
        {
            throw $this->createAccessDeniedException('Kun redaktører kan vise denne siden');
        }
        */
		$projects = $this->get('doctrine')
			->getRepository('AppBundle:Project')
			->findEditedProjects();

		$persons = $this->get('doctrine')
			->getRepository('AppBundle:Person')
			->findEditedPersons();

		$companies=$this->get('doctrine')
			->getRepository('AppBundle:Company')
			->findEditedCompanies();
		
		return $this->render(
			'edit/editList.html.twig', array(
				'projects' => $projects,
				'persons' => $persons,
				'companies' => $companies));
	}
}
