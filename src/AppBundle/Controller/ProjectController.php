<?php

namespace AppBundle\Controller;


use AppBundle\Form\SearchForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ProjectController extends Controller
{
    public function projectAction(Request $request)
    {
        $searchTerm = '';

        $form = $this -> createForm(SearchForm::class);
        $form -> handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $searchTerm = $form->getData()['search'];
        }

        $projects = $this->get('doctrine')
            ->getRepository('AppBundle:Project')
            ->findProjects($searchTerm);

        return $this->render(
            'project/project.html.twig', array(
                'projects' => $projects,
                'form' => $form -> createView()
            )
        );
    }
}