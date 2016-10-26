<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Person;
use AppBundle\Form\PersonType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PersonController extends Controller
{
	public function showAction(Request $request)
	{

		$requestID = $request->get('id');
		$person = $this->getDoctrine()->getManager()->getRepository('AppBundle:Person')->find($requestID);

		return $this->render(':actor:person.html.twig', array('person' => $person, 'key'=> $this->container->getParameter('api_key')));
	}

	public function createAction(Request $request)
	{
		if(!$this->get('security.authorization_checker')->isGranted('ROLE_USER'))
        {
            throw $this->createAccessDeniedException('Du må være en aktivert bruker og logget inn for å få lov til å definere en ny aktør');
        }
		$person = new Person();
		$form = $this->createForm(PersonType::class, $person);
		$form->handleRequest($request);

        if($form->isSubmitted()){
            $this->getDoctrine()->getManager()->getRepository('AppBundle:Project')->create($person);
            $user = $this->getUser();
            $user->addActor($person);
			$em = $this->getDoctrine()->getManager();
			$em->persist($user);
			$em->flush();
            return $this->redirect('/actor');
        }
        return $this->render(
            'actor/create_person.html.twig', array(
                'form' => $form -> createView()
            )
        );
    }
}
