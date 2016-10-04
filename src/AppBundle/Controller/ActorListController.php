<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ActorListController extends Controller
{
    public function showAction(Request $request)
    {
        $companies = $this->get('doctrine')
            ->getRepository('AppBundle:Company')
            ->findAll();

        $persons = $this->get('doctrine')
            ->getRepository('AppBundle:Person')
            ->findAll();

        return $this->render(
            'actorList/actorList.html.twig', array(
                'companies' => $companies,
                'persons' => $persons
            )
        );
    }
}