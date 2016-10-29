<?php

namespace AppBundle\Controller;

use AppBundle\Form\CompanySearchForm;
use AppBundle\Form\PersonSearchForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ActorListController extends Controller
{
	public function showAction(Request $request)
	{

		$companySearchTerm = '';
		$companyForm = $this -> createForm(CompanySearchForm::class);
		$companyForm -> handleRequest($request);
 
		if($companyForm->isSubmitted() && $companyForm->isValid()){
			$companySearchTerm = $companyForm->getData()['search'];
		}
        $companySearchTerm = (explode(" ",$companySearchTerm));

        $companies = $this->get('doctrine')
			->getRepository('AppBundle:Company')
			->findCompaniesBySearchArray($companySearchTerm);

		$personSearchTerm = '';
		$personForm = $this -> createForm(PersonSearchForm::class);
		$personForm -> handleRequest($request);
 
		if($personForm->isSubmitted() && $personForm->isValid()){
			$personSearchTerm = $personForm->getData()['search'];
		}
        $personSearchTerm = (explode(" ",$personSearchTerm));

		$persons = $this->get('doctrine')
			->getRepository('AppBundle:Person')
			->findPersonsBySearch($personSearchTerm);

		return $this->render(
			'actor/actorList.html.twig', array(
				'companies' => $companies,
				'persons' => $persons,
				'companyForm' => $companyForm->createView(),
				'personForm' => $personForm->createView()
			)
		);
	}
}