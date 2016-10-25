<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Person;
use AppBundle\Form\PersonType;use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
	public function activateUsersAction(Request $request)
	{
		if (!$this->get('security.authorization_checker')->isGranted('ROLE_EDITOR')) {
			throw $this->createAccessDeniedException();
		}
		// Create form
		$em=$this->getDoctrine()->getManager();
		$repo=$this->getDoctrine()->getManager()->getRepository('AppBundle:User');

		echo(implode('  ',$repo->findAllInActiveUsers()));
		$data = array();
		$reform = $this->createFormBuilder($data)

			->add('users', EntityType::class,
				array(
					'class' => 'AppBundle:User',
					'choices' => $repo->findAllInActiveUsers(),
					'multiple' => true,
					'expanded' => true,
                    'label' => 'Velg de brukere du vil aktivere',
					'choice_label' => function ($user) { return $user->getFullName(); }
				))

			->add('save', SubmitType::class,
		array('label' => 'Lagre'))

		->getForm();

		// Handle form-POST
		$reform->handleRequest($request);
		if ($reform->isValid()) {
			//$d = $deform->getData();
			echo('flush');
			$users = $reform["users"]->getData();
			foreach ($users as $user) { if ($user != $this->get('security.token_storage')->getToken()->getUser()) { $user->setIsActive(1); }}
			$em->flush();
            return $this->redirectToRoute('personalprofile');
		}
		return $this->render(
			'profile/activateusers.html.twig',
			array(
				'reform' => $reform->createView()
			)
		);
	}
	public function deactivateUsersAction(Request $request)
	{
		if (!$this->get('security.authorization_checker')->isGranted('ROLE_EDITOR')) {
			throw $this->createAccessDeniedException();
		}
		// Create form
		$data = array();
		$repo=$this->getDoctrine()->getManager()->getRepository('AppBundle:User');
		echo(implode('  ',$repo->findAllActiveUsers()));
		$deform = $this->createFormBuilder($data)

			->add('users', EntityType::class,
				array(
					'class' => 'AppBundle:User',
					'choices' => $repo->findAllActiveUsers(), // User objects are value
					'multiple' => true,
					'expanded' => true,
                    'label' => 'Velg de brukere du vil deaktivere',
					'choice_label' => function ($user) { return $user->getFullName(); }
				))

			->add('save', SubmitType::class,
				array('label' => 'Lagre'))

			->getForm();

		// Handle form-POST
		$deform->handleRequest($request);
		if ($deform->isValid()) {
			//$d = $deform->getData();
			echo('flush');
			$users = $deform["users"]->getData(); // returns all chosen values
            foreach ($users as $user) { if ($user != $this->get('security.token_storage')->getToken()->getUser()) { $user->setIsActive(0); }}
			$this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('personalprofile');
		}
		return $this->render(
			'profile/deactivateusers.html.twig',
			array(
				'deform' => $deform->createView()
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
		$person->setEmail($you->getEmail());
		$person->setFirstName($you->getFirstName());
		$person->setLastName($you->getLastName());
		$form = $this->createForm(PersonType::class, $person);
		$form->handleRequest($request);

		if($form->isSubmitted() && $form->isValid()){
			$this->getDoctrine()->getManager()->getRepository('AppBundle:Project')->create($person);
			$you->addActor($person);
			$em = $this->getDoctrine()->getManager();
			$em->persist($you);
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
