<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Measure;
use AppBundle\Entity\Project;
use AppBundle\Form\CreateProjectForm;
use AppBundle\Form\ProjectType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/* // Hidden imports that may be used if the IvoryGoogleMaps library is installed
use Ivory\GoogleMap\Map;
use Ivory\GoogleMap\MapTypeId;
use Ivory\GoogleMap\Base\Coordinate;
use Ivory\GoogleMap\Overlays\Animation;
use Ivory\GoogleMap\Overlays\Icon;
use Ivory\GoogleMap\Overlays\Marker;
use Buzz\Browser;
//use Ivory\GoogleMapBundle\Model\Map;
//use Ivory\GoogleMap\Overlays\MarkerShape;
*/

class ProjectController extends Controller
{
    public function showAction(Request $request)
    {
        $requestID = $request->get('id');
        $project = $this->getDoctrine()->getManager()->getRepository('AppBundle:Project')->find($requestID);
        # The API key to use on Google Maps Embed API is defined as a global parameter accessable through the service container.
        $canEdit = false;
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY') && $this->getUser()->canEditProject($project)) {
            $canEdit = true;
        }
        return $this->render('project/project.html.twig', array('project' => $project,
            'key' => $this->container->getParameter('api_key'),
            'canEdit' => $canEdit));
    }

    public function createAction(Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_USER')) {
            throw $this->createAccessDeniedException('Du må være logget inn og aktivert av en redaktør for å lage et prosjekt');
        }
        $em = $this->getDoctrine()->getManager();
        $project = new Project();
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $images = $form['imageFiles']->getData();
            foreach ($images as $image) {
                if ($image != null) {
                    $project->getImages()->add($this->get('image_service')->upload($image));
                }
            }
            $user = $this->getUser();
            $user->addProject($project);
            $em->persist($project);
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('project', array( 'id' => $project->getId() ));
        }
        return $this->render(
            'project/create.html.twig', array(
                'form' => $form->createView()
            )
        );
    }

    public function editAction(Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_GUEST')) {
            throw $this->createAccessDeniedException("Du må være logget inn og aktivert av en redaktør for å se denne siden");
        }

        $requestID = $request->get('id');
        $project = $this->getDoctrine()->getManager()->getRepository('AppBundle:Project')->find($requestID);

        if (!$this->getUser()->canEditProject($project) && !$this->get('security.authorization_checker')->isGranted('ROLE_EDITOR')) {
            throw $this->createAccessDeniedException("Du har ikke redigeringsrettigheter til dette prosjektet");
        }

        $form = $this->createForm(ProjectType::class, $project, array('method' => 'PUT'));
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $imageFiles = $form['imageFiles']->getData();
            $urls = clone $project->getImages(); // returns an array, ja?
            foreach ($imageFiles as $image) {
                if ($image != null) {
                    $urls->add($this->get('image_service')->upload($image));
                }
            }
            $project->setImages($urls);
            $project->incrementVersion();
            $em = $this->getDoctrine()->getManager();
            $em->persist($project);
            $em->flush();
            return $this->redirectToRoute('project', array( 'id' => (string)$requestID) );
        }
        return $this->render(
            'project/edit.html.twig', array(
                'form' => $form->createView()
            )
        );
    }
}
