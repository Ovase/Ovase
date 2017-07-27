<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Person;
use AppBundle\Form\PersonType;use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use AppBundle\Form\EditUserType;
//use Symfony\Component\Config\Definition\Exception\Exception;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

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

		// echo(implode('  ',$repo->findAllInActiveUsers()));
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

			->add('save', SubmitType::class, array('label' => 'Lagre'))
		->getForm();

		// Handle form-POST
		$reform->handleRequest($request);
		if ($reform->isValid()) {
			//$d = $deform->getData();
			echo('flush');
			$users = $reform["users"]->getData();
			foreach ($users as $user) {
				if ($user != $this->get('security.token_storage')->getToken()->getUser()) {
					$user->setIsActive(1);
					$this->sendApprovedUserEmail($user);
					$em->persist($user);
				}
			}
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
	public function editMyProfileAction(Request $request)
	{
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_USER')) {
            throw $this->createAccessDeniedException();
        }
		$you = $this->get('security.token_storage')->getToken()->getUser();
        $form = $this->createForm(EditUserType::class, $you);
        $em = $this->getDoctrine()->getManager();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) { // Is not valid?
            $em->flush();
            return $this->redirectToRoute('personalprofile');
        }
        return $this->render(
            'login/register.html.twig',
            array('form' => $form->createView())
        );
    }
	public function editProfileAction(Request $request)
	{
		if (!$this->get('security.authorization_checker')->isGranted('ROLE_EDITOR')) {
			throw $this->createAccessDeniedException("Kun redaktører skal kunne redigere andres brukerprofiler.");
		}
		$id = $request->get('id');
		$user = $this->getDoctrine()->getRepository('AppBundle:User')->find($id);
		$form = $this->createForm(EditUserType::class, $user);
        $em = $this->getDoctrine()->getManager();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) { // Is not valid?
			$em->flush();
			//return $this->redirectToRoute('personalprofile');
		}
		return $this->render(
			'login/register.html.twig',
			array('form' => $form->createView())
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
		// echo(implode('  ',$repo->findAllActiveUsers()));
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

		$em = $this->getDoctrine()->getManager();
		// Handle form-POST
		$deform->handleRequest($request);
		if ($deform->isValid()) {
			//$d = $deform->getData();
			echo('flush');
			$users = $deform["users"]->getData(); // returns all chosen values
			foreach ($users as $user) {
				if ($user != $this->get('security.token_storage')->getToken()->getUser()) {
					$user->setIsActive(0);
					$em->persist($user);
				}
			}
			$em->flush();
			return $this->redirectToRoute('personalprofile');
		}
		return $this->render(
			'profile/deactivateusers.html.twig',
			array(
				'deform' => $deform->createView()
			)
		);
	}
	public function promoteEditorUsersAction(Request $request)
	{
		if (!$this->get('security.authorization_checker')->isGranted('ROLE_EDITOR')) {
			throw $this->createAccessDeniedException();
		}
		// Create form
		$em=$this->getDoctrine()->getManager();
		$repo=$em->getRepository('AppBundle:User');

		// echo(implode('  ',$repo->findAllInActiveUsers()));
		$data = array();
		$reform = $this->createFormBuilder($data)

			->add('users', EntityType::class,
				array(
					'class' => 'AppBundle:User',
					'choices' => $repo->findAllActivatedNormalUsers(),
					'multiple' => true,
					'expanded' => true,
					'label' => 'Velg de brukere du vil oppnevne til redaktør',
					'choice_label' => function ($user) { return $user->getFullName(); }
				))

			->add('save', SubmitType::class, array('label' => 'Lagre'))
		->getForm();

		// Handle form-POST
		$reform->handleRequest($request);
		if ($reform->isValid()) {
			$users = $reform["users"]->getData();
			foreach ($users as $user) {
				if ($user != $this->get('security.token_storage')->getToken()->getUser()) {
					$user->addRole('ROLE_EDITOR');
					// Need to create new ArrayCollection object since Doctrine
					// checks object reference to see if property has changed
					$user->setRoles(new ArrayCollection($user->getRoles()));
					$this->sendPromotedEditorEmail($user);
				}
			}
			$em->flush();
			return $this->redirectToRoute('personalprofile');
		}
		return $this->render(
			'profile/promoteEditors.html.twig',
			array(
				'reform' => $reform->createView()
			)
		);
	}
	public function demoteEditorUsersAction(Request $request)
	{
		if (!$this->get('security.authorization_checker')->isGranted('ROLE_EDITOR')) {
			throw $this->createAccessDeniedException();
		}
		// Create form
		$em=$this->getDoctrine()->getManager();
		$repo=$em->getRepository('AppBundle:User');

		// echo(implode('  ',$repo->findAllInActiveUsers()));
		$data = array();
		$reform = $this->createFormBuilder($data)

			->add('users', EntityType::class,
				array(
					'class' => 'AppBundle:User',
					'choices' => $repo->findAllActivatedEditorUsers(),
					'multiple' => true,
					'expanded' => true,
					'label' => 'Velg de brukere som ikke lenger skal være redaktør',
					'choice_label' => function ($user) { return $user->getFullName(); }
				))

			->add('save', SubmitType::class, array('label' => 'Lagre'))
		->getForm();

		// Handle form-POST
		$reform->handleRequest($request);
		if ($reform->isValid()) {
			$users = $reform["users"]->getData();
			foreach ($users as $user) {
				if ($user != $this->get('security.token_storage')->getToken()->getUser()) {
					$user->removeRole('ROLE_EDITOR');
					// Need to create new ArrayCollection object since Doctrine
					// checks object reference to see if property has changed
					$user->setRoles(new ArrayCollection($user->getRoles()));
				}
			}
			$em->flush();
			return $this->redirectToRoute('personalprofile');
		}
		return $this->render(
			'profile/demoteEditors.html.twig',
			array(
				'reform' => $reform->createView()
			)
		);
	}
	public function queryMeAction(Request $request)
	{
		if (!$this->get('security.authorization_checker')->isGranted('ROLE_USER')) {
			throw $this->createAccessDeniedException();
		}
		$you = $this->get('security.token_storage')->getToken()->getUser();
		$first = $you->getFirstName(); // Search functionality needs fixing
		$last = $you->getLastName(); // Search functionality needs fixing
		$s = $this->getDoctrine()->getRepository('AppBundle:Person')->findPersonsBySearch(array($first,$last)); // returns an array, ja?
		if (!(empty($s))) {
			$p = reset($s); // Is this OK, Mommy?
			return $this->render(':actor:person.html.twig', array('person' => $p, 'key'=> $this->container->getParameter('api_key')));
		}
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
			return $this->redirectToRoute('actorlist');
		}
		return $this->render(
			'actor/create_person.html.twig', array(
				'form' => $form -> createView()
			)
		);
	}
    private function sendApprovedUserEmail($user) {
        $to_addr = $user->getEmail();
        $from_addr = array('ikkesvar@ovase.no' => 'Ovase.no');
        if ($this->get('kernel')->isDebug())      
            $from_addr = 'ovase.testmail@gmail.com';

        $message = \Swift_Message::newInstance()
            ->setSubject('Aktivert bruker')
            ->setFrom($from_addr)
            ->setTo(array($to_addr => $user->getFullName()))
            ->setBody(
            	$this->get('twig')->render('email/approved.user.html.twig', array(
        			'user' => $user,
        			'newPersonRoute' => $this->generateUrl('create_person', array(), UrlGeneratorInterface::ABSOLUTE_URL))),
            	'text/html');

        $this->get('mailer')
            ->send($message);
    }
    private function sendPromotedEditorEmail($user) {
        $to_addr = $user->getEmail();
        $from_addr = array('ikkesvar@ovase.no' => 'Ovase.no');
        if ($this->get('kernel')->isDebug())      
            $from_addr = 'ovase.testmail@gmail.com';

        $message = \Swift_Message::newInstance()
            ->setSubject('Du har blitt redaktør')
            ->setFrom($from_addr)
            ->setTo(array($to_addr => $user->getFullName()))
            ->setBody($this->get('twig')->render('email/promoted.editor.twig', array('user' => $user)), 'text/plain');

        $this->get('mailer')
            ->send($message);
    }
}
