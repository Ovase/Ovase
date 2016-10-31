<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Form\UserType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\Form;

class UserController extends Controller
{
    public function showAllUsersAction() {

        return $this->render(
            'login/userlist.html.twig', // TO BE implemented
            array('babes' => $this->getDoctrine()->getManager()->getRepository('AppBundle:User')->findAll())
        );

    }
	public function registerAction(Request $request)
	{
		// 1) build the form
		$user = new User();
		$form = $this->createForm(UserType::class, $user, array(
        'environment' => $this->get( 'kernel' )->getEnvironment()
    	));

		// 2) handle the submit (will only happen on POST)
		$form->handleRequest($request);
        $this->validatePassword($form);
		if ($form->isSubmitted() && $form->isValid()) {

            // 3) Encode the password with bcrypt (you could also do this via Doctrine listener)
            $plainPassword = $form->get('password')->getData();
            $encoder = $this->container->get('security.password_encoder');
            $encodedPass = $encoder->encodePassword($user, $plainPassword);
            $user->setPassword($encodedPass);

			// Authorize User as... GUEST. TODO: Remove Guest role, as it is not needed. We can always just use IS_AUTHENTICATED_FULLY.
			$user->addRole("ROLE_USER");
			
			$user->setIsActive(0); // YOU! SHALL NOT! PASS!!
			
			// 4) save the User!
			$em = $this->getDoctrine()->getManager();
			$em->persist($user);
			$em->flush();

			return $this->redirectToRoute('login',array(),301);
		}

		return $this->render(
			'login/register.html.twig',
			array('form' => $form->createView())
		);
	}
    // Password validation. May be subject to change? Does it conflict w/ usability requirements?
	private function validatePassword(Form $form){
        //$password = $form['password']->getData();
        $password = $form->get('password')->getData();
        if (! preg_match("/^(?=.*[a-z]).+$/", $password)) {
            $form->addError(new FormError("Ditt passord må inneholde minst 1 liten bokstav fra det engelske alfabetet!"));
        }
        if (! preg_match("/^(?=.*[A-Z]).+$/", $password)) {
            $form->addError(new FormError("Ditt passord må inneholde minst 1 stor bokstav fra det engelske alfabetet!"));
        }
        if (! preg_match("/^(?=.*[æøåÆØÅ]).+$/", $password)) {
            $form->addError(new FormError("Ditt passord må inneholde minst 1 av de spesielle bokstavene i det dansk-norske alfabet!"));
        }
        if (strcspn($password, '0123456789') == strlen($password)) // see http://php.net/manual/en/function.strcspn.php - it is infact faster then a number regex
        {
            $form->addError(new FormError("Ditt passord må inneholde minst ett siffer!"));
        }
        if (! preg_match("/^(?=.*[!#¤_%&=?£]).+$/", $password)) {
            $form->addError(new FormError("Ditt passord må inneholde minst ett spesialtegn. Kontakt systemets administrator for nærmere informasjon"));
        }
        if (strlen($password)<7) {
            $form->addError(new FormError("Ditt passord må være minst åtte tegn langt. Kontakt systemets administrator for nærmere informasjon")); //Hvorfor skal man kontakte sysadm for dette??
        }
	}
}
