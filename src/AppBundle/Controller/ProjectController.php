<?php

namespace AppBundle\Controller;

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
		# Api key to use on Google Maps Embed API!
		$api = "AIzaSyBDQD6CvPGK5_Bhhn3xkY710Dm-RsQGG70";
		$project = $this->getDoctrine()->getManager()->getRepository('AppBundle:Project')->find($requestID);
		return $this->render('project/project.html.twig', array('project' => $project, 'key'=>$api ));
	}

	public function createAction(Request $request)
	{
		$project = new Project();
		$form = $this->createForm(ProjectType::class, $project);
		$form->handleRequest($request);
		if($form->isValid()){
			$this->getDoctrine()->getManager()->getRepository('AppBundle:Project')->create($project);
			return $this->redirect('/anlegg');
		}
		return $this->render(
			'project/create.html.twig', array(
				'form' => $form -> createView(),
			)
		);
	}
}
