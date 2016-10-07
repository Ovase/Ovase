<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Person;
use AppBundle\Form\PersonType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PersonController extends Controller
{
    public function showAction(Request $request)
    {

        $requestID = $request->get('id');
        $person = $this->getDoctrine()->getManager()->getRepository('AppBundle:Person')->find($requestID);

        return $this->render(':actor:person.html.twig', array('person' => $person));
    }

    public function createAction(Request $request)
    {
        $person = new Person();
        $form = $this->createForm(PersonType::class, $person);
        $form->handleRequest($request);

        if($form->isSubmitted()){
            $this->getDoctrine()->getManager()->getRepository('AppBundle:Project')->create($person);
            return $this->redirect('/actor');
        }
        return $this->render(
            'actor/create_person.html.twig', array(
                'form' => $form -> createView()
            )
        );
    }
}