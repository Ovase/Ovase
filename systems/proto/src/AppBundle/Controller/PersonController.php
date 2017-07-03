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
        $canEdit = false;
        $deleteForm = null;
        if ($this->userCanEditPerson($person)) {
            $canEdit = true;
            $deleteForm = $this->createDeleteForm($person)->createView();
        }

		return $this->render(':actor:person.html.twig', array(
            'person' => $person,
            'canEdit' => $canEdit,
            'actorDeleteForm' => $deleteForm,
            'key'=> $this->container->getParameter('api_key')
            ));
	}

	public function createAction(Request $request)
	{
		if(!$this->get('security.authorization_checker')->isGranted('ROLE_USER'))
        {
            throw $this->createAccessDeniedException('Du må være en aktivert bruker og logget inn for å få lov til å definere en ny aktør');
        }
        $em = $this->getDoctrine()->getManager();
		$person = new Person();
		$form = $this->createForm(PersonType::class, $person);
		$form->handleRequest($request);

        if($form->isValid()){
            $url = null;
            if ($form['image']->getData() != null) {$url = $this->get('image_service')->upload($form['image']->getData()); }
            $person->setImage($url);
            $em->persist($person);
            $user = $this->getUser();
            $user->addActor($person);
			$em->persist($user);
			$em->flush();
            return $this->redirectToRoute('person', array( 'id' => $person->getId() ));
        }
        return $this->render(
            'actor/create_person.html.twig', array(
                'form' => $form -> createView()
            )
        );
    }

    public function editAction(Request $request) {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_USER')) {
            throw $this->createAccessDeniedException("Du må være logget inn og aktivert av en redaktør for å se denne siden");
        }

        $requestID = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $person = $em->getRepository('AppBundle:Person')->find($requestID);

        if (!$this->userCanEditPerson($person)) {
            throw $this->createAccessDeniedException("Du har ikke redigeringsrettigheter til denne siden");
        }

        $form = $this->createForm(PersonType::class, $person);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $url = $person->getImage();
            if ($form['image']->getData() != null) {
                // TODO: Delete the old image if a new one is uploaded
                $url = $this->get('image_service')->upload($form['image']->getData());
            }
            $person->setImage($url);
            $em->persist($person);
            $em->flush();
            return $this->redirectToRoute('person', array( 'id' => $person->getId() ));
        }

        return $this->render('actor/create_person.html.twig', array(
            'form' => $form->createView()
            ));

    }

    public function deleteAction(Request $request) {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_USER')) {
            throw $this->createAccessDeniedException("Du må være logget inn og aktivert av en redaktør for å se denne siden");
        }

        $requestID = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $person = $em->getRepository('AppBundle:Person')->find($requestID);

        if (!$this->userCanEditPerson($person)) {
            throw $this->createAccessDeniedException("Du har ikke redigeringsrettigheter til denne siden");
        }

        $form = $this->createDeleteForm($person);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // TODO: Delete actor image
            $em->remove($person);
            $em->flush();
        }

        return $this->redirectToRoute('actorlist');
    }

    private function userCanEditPerson($person) {
        // Not logged in?
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY'))
            return false;
        // Not associated with actor and not an editor?
        if (!$this->getUser()->canEditActor($person) &&
            !$this->get('security.authorization_checker')->isGranted('ROLE_EDITOR'))
            return false;
        return true;
    }

    private function createDeleteForm($person) {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('delete_person',
                array('id' => $person->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}
