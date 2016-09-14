<?php
/**
 * Created by PhpStorm.
 * User: futurnur
 * Date: 14/09/16
 * Time: 14:40
 */

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProjectController extends Controller
{
    public function projectAction()
    {
        $projects = $this->get('doctrine')->getRepository('AppBundle:Project')->findAll();
        return $this->render(
            'project/project.html.twig', array(
                'projects' => $projects
            )
        );
    }

}