<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Project;
use AppBundle\Form\CreateProjectForm;
use AppBundle\Form\ProjectType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Ivory\GoogleMap\Map;
use Ivory\GoogleMap\MapTypeId;
use Ivory\GoogleMap\Base\Coordinate;
use Ivory\GoogleMap\Map;
use Ivory\GoogleMap\Overlay\Marker;
use Ivory\GoogleMap\Overlay\Animation;
use Ivory\GoogleMap\Overlay\Icon;
use Ivory\GoogleMap\Overlay\MarkerShape;
use Ivory\GoogleMap\Overlay\MarkerShapeType;

class ProjectController extends Controller
{
	public function showAction(Request $request)
	{
		$requestID = $request->get('id');
		$map = new Map(); // don't forget to render
		$project = $this->getDoctrine()->getManager()->getRepository('AppBundle:Project')->find($requestID);
		// Sets the center
		$map->setCenter(new Coordinate(63.0, 10.0)); // Trondhjæm by <3
		// Sets full screen control option
		$map->setMapOption('fullscreenControl', false);
		// Sets the zoom
		$map->setMapOption('zoom', 3); // alternatively - $map->setAutoZoom(true);
		// For more options you can set, visit
		// https://developers.google.com/maps/documentation/javascript/reference#MapOptions
		
		/* For each coordinate for each project, put a marker in map
		foreach ($actors as $pe) {
			
		} */
		$c = $project->getLocation();
		$marker = new Marker(
			$c,
			Animation::BOUNCE,
			null,
			new MarkerShape(MarkerShapeType::CIRCLE, [1.1, 2.1, 1.4]),
			['clickable' => true]
		);

		return $this->render('project/project.html.twig', array('project' => $project, 'map' => $map ));
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
				'form' => $form -> createView()
			)
		);
	}
}
