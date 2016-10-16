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
//use Ivory\GoogleMapBundle\Model\Map;
use Ivory\GoogleMap\Overlay\Marker;
use Ivory\GoogleMap\Overlay\Animation;
use Ivory\GoogleMap\Overlay\Icon;
use Ivory\GoogleMap\Overlay\MarkerShape;
use Ivory\GoogleMap\Overlay\MarkerShapeType;
use Buzz\Browser;

class ProjectController extends Controller
{
	public function showAction(Request $request)
	{
		$requestID = $request->get('id');
		//$map = new Map(); // don't forget to render
		$map = $this->get('ivory_google_map.map'); // Usage as of 2.2.1?
		$project = $this->getDoctrine()->getManager()->getRepository('AppBundle:Project')->find($requestID);

		// Sets full screen control option
		$map->setMapOption('fullscreenControl', false);
		// Sets the zoom
		$map->setMapOption('zoom', 3); // alternatively - $map->setAutoZoom(true);
		// For more options you can set, visit
		// https://developers.google.com/maps/documentation/javascript/reference#MapOptions
		
		/* For each coordinate for each project, put a marker in map -> Projectlist
		foreach ($actors as $pe) {
			
		} */
		$c = $project->getLocation(); // Must be a vaild array
		$map->setCenter($c);
		$marker = new Marker(
			$c,
			Animation::BOUNCE,
			null,
			new MarkerShape(MarkerShapeType::CIRCLE, [1.1, 2.1, 1.4]),
			['clickable' => true]
		); //???

		return $this->render('project/project.html.twig', array('project' => $project, 'map' => $map, 'marker' => $marker ));
	}

	public function createAction(Request $request)
	{
		$project = new Project();
		$form = $this->createForm(ProjectType::class, $project);
		$form->handleRequest($request);
		if($form->isValid()){
			$geocoder = $this->get('ivory_google_map.geocoder'); // instantiate geocoder service
			// Geocode the address from place.
			$response = $geocoder->geocode($project->getPlace()); // returns a collection of addresses, assuming only one address is there...
			$results = $response->getResults();
			$first = reset($results); // the safe way of getting the first element in the array
			if ($first) { $project->setLocation($first->getGeometry()->getLocation()); } // else we keep the default at Equator
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
