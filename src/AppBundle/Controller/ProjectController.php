<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Project;
use AppBundle\Form\CreateProjectForm;
use AppBundle\Form\ProjectType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ProjectController extends Controller
{
    public function showAction(Request $request)
    {
        $requestID = $request->get('id');
        $project = $this->getDoctrine()->getManager()->getRepository('AppBundle:Project')->find($requestID);

        $canEdit = $project->getUsers()->get(0);
        return $this->render('project/project.html.twig', array('project' => $project, 'message' => "$canEdit kan endre dette prosjektet"));
    }

    public function createAction(Request $request)
    {
        if(!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY'))
        {
            throw $this->createAccessDeniedException();
        }

        $project = new Project();
        $user = $this->getUser();
        $project->addUser($user);
        $project->addActor($user->getPerson());
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $this->getDoctrine()->getManager()->getRepository('AppBundle:Project')->create($project);
            return $this->redirect('/anlegg');
        }
        return $this->render(
            'project/create.html.twig', array(
                'form' => $form->createView()
            )
        );
    }
}
