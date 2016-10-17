<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Company;
use AppBundle\Form\CompanyType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CompanyController extends Controller
{
	public function showAction(Request $request)
	{

		$requestID = $request->get('id');
		$project = $this->getDoctrine()->getManager()->getRepository('AppBundle:Company')->find($requestID);

		return $this->render(':actor:company.html.twig', array('project' => $project, 'key'=> $this->container->getParameter('api_key')));
	}

	public function createAction(Request $request)
	{
		$company = new Company();
		$form = $this->createForm(CompanyType::class, $company);
		$form->handleRequest($request);

		if($form->isSubmitted()){
			$this->getDoctrine()->getManager()->getRepository('AppBundle:Company')->create($company);
			return $this->redirect('/actor');
		}
		return $this->render(
			'actor/create_company.html.twig', array(
				'form' => $form -> createView()
			)
		);
	}
}