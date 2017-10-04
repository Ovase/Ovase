<?php
// src/AppBundle/Command/PromoteUserCommand.php
namespace AppBundle\Command;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Doctrine\ORM\NoResultException;

class PromoteUserCommand extends ContainerAwareCommand
{
	protected function configure()
	{
		$this
		// the name of the command (the part after "app/console")
		->setName('app:prom-user')

		// the short description shown while running "php app/console list"
		->setDescription('Give a user a new role.')
		->addArgument('username', InputArgument::REQUIRED, 'The username of the user.') // Required argument
		
		// the full command description shown when running the command with
		// the "--help" option
		->setHelp("This command allows you to change the authorization of someone...");
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		// Prohibit command from executing unless we are in the test environment. Tip: use --env=dev
		// $env = $this->getContainer()->getParameter('kernel.environment');
		// if (($env != 'dev') { return; }
		// outputs multiple lines to the console (adding "" at the end of each line)
		$output->writeln([
			'User Roleplayer',
			'============',
			'',
		]);

		$em = $this->getContainer()->get('doctrine')->getManager();
		$user = null;
		try {
			$user = $em->getRepository("AppBundle:User")->findUserByEmail($input->getArgument('username'));
		} catch (NoResultException $t) {
			$output->writeln('That user is in another castle. Bye!');
			return;
		}

		// outputs a message followed by a ""
		$output->writeln('Howdy, partner! You are currently operating on user');
		$output->writeln($user->getFullName());

		// outputs a message without adding a "" at the end of the line
		$output->write('You are about to ');
		$output->write("do sum'thin' BAD.");
		$output->writeln('');
		$helper = $this->getHelper('question');

		$rolequestion = new ChoiceQuestion(
			'Please select the user role (defaults to USER)',
			array("inactive", "ROLE_USER","ROLE_EDITOR"),
			0
		);
		$rolequestion->setErrorMessage('Role %s is invalid.');

		// Assuming valid role 
		$role = $helper->ask($input, $output, $rolequestion);
		$output->writeln('You have just selected: '.$role);
		if ($role == "inactive") {
			$user->setIsActive(0); // YOU SHALL NOT PASS!!!...
            $roles = new ArrayCollection();
            $user->setRoles($roles);
		}
		else if ($role == "ROLE_USER") {
            $user->setIsActive(1); // For now, you may pass...
            $roles = new ArrayCollection();
            $roles->add("ROLE_USER");
            $user->setRoles($roles);
            // $this->sendApprovedUserEmail($user);
		}
		else if ($role == "ROLE_EDITOR") {
            $user->setIsActive(1); // For now, you may pass...
		    $roles = new ArrayCollection();
            $roles->add("ROLE_USER");
            $roles->add("ROLE_EDITOR");
		    $user->setRoles($roles);
            // $this->sendApprovedUserEmail($user);
		}
		else { return; }
		$em->persist($user);
		$em->flush();
		$em->close();

		$output->writeln('Bye!');
	}

	private function sendApprovedUserEmail($user) {
        $to_addr = $user->getEmail();
        $from_addr = array('ikkesvar@ovase.no' => 'Ovase.no');
        /* NOTE:
         * For commands, the env. is controlled with --env=dev/prod
         * The dev env. by default has debug set to true
         */
        if ($this->getContainer()->get('kernel')->isDebug())      
            $from_addr = 'ovase.testmail@gmail.com';

        $twig = $this->getContainer()->get('twig');
        $router = $this->getContainer()->get('router');
        $newPersonRoute = $router->generate('create_person');
        $emailBody = 
            $twig->render('email/approved.user.html.twig', array(
                'user' => $user,
                'newPersonRoute' => $newPersonRoute));

        $message = \Swift_Message::newInstance()
            ->setSubject('Aktivert bruker')
            ->setFrom($from_addr)
            ->setTo(array($to_addr => $user->getFullName()))
            ->setBody($emailBody, 'text/html');

        $this->getContainer()->get('mailer')
            ->send($message);
    }
}