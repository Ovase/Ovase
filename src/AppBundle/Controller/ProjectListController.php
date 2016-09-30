<?php

namespace AppBundle\Controller;


use AppBundle\Form\SearchForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ProjectListController extends Controller
{
    public function projectListAction(Request $request)
    {
        $searchTerm = '';

        $form = $this -> createForm(SearchForm::class);
        $form -> handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $searchTerm = $form->getData()['search'];
        }
        
        $projects = $this->get('doctrine')
            ->getRepository('AppBundle:Project')
            ->findBySearch($searchTerm);

        return $this->render(
            'projectList/projectList.html.twig', array(
                'projects' => $projects,
                'form' => $form -> createView()
            )
        );
    }
}