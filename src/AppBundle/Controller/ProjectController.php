<?php
/**
 * Created by PhpStorm.
 * User: Pål
 * Date: 19/09/2016
 * Time: 15:04
 */

namespace AppBundle\Controller;

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
}
