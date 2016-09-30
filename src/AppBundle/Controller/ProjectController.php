<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Project;
use AppBundle\Form\CreateProjectForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ProjectController extends Controller
{
    public function showAction(Request $request)
    {
        $requestID = $request->get('id');
        $project = $this->getDoctrine()->getManager()->getRepository('AppBundle:Project')->find($requestID);

        return $this->render('project/project.html.twig', array('project' => $project));
    }

    public function createAction(Request $request)
    {
        $project = new Project();
        $form = $this->createForm(CreateProjectForm::class, $project);
        if($form->isSubmitted() && $form->isValid()){
            echo 'submitted';
            var_dump($project);
            $this->getDoctrine()->getManager()->getRepository('Project')->create($project);
            return $this->redirect('/anlegg');
        }
        return $this->render(
            ':project:create.html.twig', array(
                'form' => $form -> createView()
            )
        );
    }
}
