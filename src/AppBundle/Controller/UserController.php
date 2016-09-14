<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Doctrine\DBAL\DBALException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use AppBundle\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends Controller
{
/*
    public function showHomeAction()
    {
        return $this->render('home/index.html.twig');
    }
*/
    public function registerAction(Request $request)
    {
        // 1) build the form
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // 3) Encode the password (you could also do this via Doctrine listener)
            $password = $this->get('security.password_encoder')
                ->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            $user->addRole("ROLE_USER");
			// 4) save the User!
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            // TODO:
			// ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user

            // TODO: Insert coorect route. Hint: routing.yml
			return $this->redirectToRoute('replace_with_some_route');
        }

        return $this->render(
            'login/register.html.twig',
            array('form' => $form->createView())
        );
    }
}