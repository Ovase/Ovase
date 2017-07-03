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
		$company = $this->getDoctrine()->getManager()->getRepository('AppBundle:Company')->find($requestID);
        $canEdit = false;
        $deleteForm = null;
        if ($this->userCanEditCompany($company)) {
            $canEdit = true;
            $deleteForm = $this->createDeleteForm($company)->createView();
        }
		return $this->render(':actor:company.html.twig', array(
            'company' => $company,
            'canEdit' => $canEdit,
            'actorDeleteForm' => $deleteForm,
            'key'=> $this->container->getParameter('api_key')
            ));
	}

    public function createAction(Request $request)
    {
        if(!$this->get('security.authorization_checker')->isGranted('ROLE_USER'))
        {
            throw $this->createAccessDeniedException('Du må være aktivert i systemet og logget inn for å definere et selskap');
        }
        $em = $this->getDoctrine()->getManager();
        $company = new Company();
        $form = $this->createForm(CompanyType::class, $company);
        $form->handleRequest($request);

		if($form->isValid()){
            $url = null;
            if ($form['image']->getData() != null) {$url = $this->get('image_service')->upload($form['image']->getData()); }
            $company->setImage($url);
			$em->persist($company);
            $user = $this->getUser();
            $user->addActor($company);
			$em->persist($user);
			$em->flush();
            return $this->redirectToRoute('company', array( 'id' => $company->getId() ));
		}
		return $this->render(
			'actor/create_company.html.twig', array(
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
        $company = $em->getRepository('AppBundle:Company')->find($requestID);

        if (!$this->userCanEditCompany($company)) {
            throw $this->createAccessDeniedException("Du har ikke redigeringsrettigheter til denne siden");
        }

        $form = $this->createForm(CompanyType::class, $company);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $url = $company->getImage();
            if ($form['image']->getData() != null) {
                // TODO: Delete the old image if a new one is uploaded
                $url = $this->get('image_service')->upload($form['image']->getData());
            }
            $company->setImage($url);
            $em->persist($company);
            $em->flush();
            return $this->redirectToRoute('company', array( 'id' => $company->getId() ));
        }

        return $this->render('actor/create_company.html.twig', array(
            'form' => $form->createView()
            ));
    }

    public function deleteAction(Request $request) {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_USER')) {
            throw $this->createAccessDeniedException("Du må være logget inn og aktivert av en redaktør for å se denne siden");
        }

        $requestID = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $company = $em->getRepository('AppBundle:Company')->find($requestID);

        if (!$this->userCanEditCompany($company)) {
            throw $this->createAccessDeniedException("Du har ikke redigeringsrettigheter til denne siden");
        }

        $form = $this->createDeleteForm($company);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // TODO: Delete actor image
            $em->remove($company);
            $em->flush();
        }

        return $this->redirectToRoute('actorlist');
    }

    private function userCanEditCompany($company) {
        // Not logged in?
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY'))
            return false;
        // Not associated with actor and not an editor?
        if (!$this->getUser()->canEditActor($company) &&
            !$this->get('security.authorization_checker')->isGranted('ROLE_EDITOR'))
            return false;
        return true;
    }

    private function createDeleteForm($company) {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('delete_company',
                array('id' => $company->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}