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

    public function registerAction(Request $request)
    {
        // 1) build the form
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // 3) Encode the password and set user salt (you could also do this via Doctrine listener)
			$salt=generateSalt()
			if ($salt===null) { $password = $this->get('security.password_encoder')->encodePassword($user, $user->getPlainPassword()); }
            else {  $password = $this->get('security.encoder_factory')->getEncoder(User::class)->encodePassword($user->getPlainPassword, $salt); }
			$user->setPassword($user->getPlainPassword(), $this->get('security.encoder_factory'));

            $user->addRole("ROLE_USER");
			// 4) save the User!
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            // TODO:
			// ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user


			return $this->redirectToRoute('create_user');
        }

        return $this->render(
            'login/register.html.twig',
            array('form' => $form->createView())
        );
    }
    private function validPassLen($password){
        return strlen($password)>=7;
    }

    /**
     * Generates a Salt
     *
     * Generates a random 64-byte long string by converting a 32 byte binary
     * openssl pseudo random string into a 64 byte hex string.
     *
     * @return null|string  the salt. If null is returned, something went wrong.
     */
    private function generateSalt()
    {
        $salt = null;
        $isSecure = 0;
        $ATTEMPTS_LIMIT = 9999; // fail-safe for infinite loop

        while (!$isSecure && $ATTEMPTS_LIMIT > 0) {
            $salt = bin2hex(openssl_random_pseudo_bytes(32, $isSecure));
            $ATTEMPTS_LIMIT--;
        }
        return $salt;
    }
}