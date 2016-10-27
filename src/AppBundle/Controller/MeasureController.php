<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Measure;
use AppBundle\Form\MeasureType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MeasureController extends Controller
{

    public function createAction(Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException('Du må være logget inn for å lage et prosjekt');
        }
        $em = $this->getDoctrine()->getManager();
        $project = $em->find('AppBundle:Project', $request->get('project_id'));
        if (!$this->getUser()->canEditProject($project)) {
            throw $this->createAccessDeniedException("Du har ikke redigeringsrettigheter til dette prosjektet");
        }
        $measure = new Measure();
        $form = $this->createForm(MeasureType::class, $measure);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($measure);
            $project->addMeasure($measure);
            $em->persist($project);
            $em->flush();
            return $this->redirect('/anlegg/' . $project->getId());
        }
        return $this->render(
            'project/create.html.twig', array(
                'form' => $form->createView()
            )
        );
    }

    public function editAction(Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException('Du må være logget inn for å lage et prosjekt');
        }
        $em = $this->getDoctrine()->getManager();
        $project = $em->find('AppBundle:Project', $request->get('project_id'));
        if (!$this->getUser()->canEditProject($project)) {
            throw $this->createAccessDeniedException("Du har ikke redigeringsrettigheter til dette prosjektet");
        }
        $measure = $em->find('AppBundle:Measure', $request->get('measure_id'));
        $form = $this->createForm(MeasureType::class, $measure, array('method' => 'PUT'));
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($measure);
            $em->flush();
            return $this->redirect('/anlegg/' . $project->getId());
        }
        return $this->render(
            'project/create.html.twig', array(
                'form' => $form->createView()
            )
        );
    }

    public function deleteAction(Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException('Du må være logget inn');
        }
        $em = $this->getDoctrine()->getManager();
        $project = $em->find('AppBundle:Project', $request->get('project_id'));
        if (!$this->getUser()->canEditProject($project)) {
            throw $this->createAccessDeniedException("Du har ikke redigeringsrettigheter til dette prosjektet");
        }
        $measure = $em->find('AppBundle:Measure', $request->get('measure_id'));
        $em->remove($measure);
        $em->flush();
        return $this->redirect('/anlegg/' . $project->getId());
    }
}