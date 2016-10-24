<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
//use Symfony\Component\Config\Definition\Exception\Exception;

class ProfileController extends Controller
{
	public function showMyProfileAction()
	{
		if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
			throw $this->createAccessDeniedException();
		}
		$user = $this->get('security.token_storage')->getToken()->getUser();
		return $this->render(
			'profile/personal.html.twig', array(
				'user' => $user
			)
		);
	}
	public function showProfileAction(Request $request)
	{
		if (!$this->get('security.authorization_checker')->isGranted('ROLE_USER')) {
			throw $this->createAccessDeniedException();
		}
		$id = $request->get('id');
		$user = $this->getDoctrine()->getRepository('AppBundle:User')->find($id);
		return $this->render(
			'profile/public.html.twig', array(
				'user' => $user
			)
		);
	}
	public function queryMeAction(Request $request)
	{
		if (!$this->get('security.authorization_checker')->isGranted('ROLE_USER')) {
			throw $this->createAccessDeniedException();
		}
		$you = $this->get('security.token_storage')->getToken()->getUser();
		$n = $you->getFullName();
		$s = $this->getDoctrine()->getRepository('AppBundle:Person')->findPersonsBySearch($n); // returns an array, ja?
		if (!(empty($s))) { // Is this OK, Mommy?
			$p = reset($s);
			return $this->render(':actor:person.html.twig', array('person' => $p, 'key'=> $this->container->getParameter('api_key')));
		}
		//return $this->redirectToRoute('create_person'); // Not filling stuff on beforehand
		$person = new Person();
		$person->setEmail("");
		//
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
