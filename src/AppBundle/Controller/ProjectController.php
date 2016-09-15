<?php
/**
 * Created by PhpStorm.
 * User: futurnur
 * Date: 14/09/16
 * Time: 14:40
 */

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ProjectController extends Controller
{
    public function projectAction(Request $request)
    {
        $search = $request->get('search');
        $projects = $this->get('doctrine')->getRepository('AppBundle:Project')->findProjects($search);
        return $this->render(
            'project/project.html.twig', array(
                'projects' => $projects
            )
        );
    }
}