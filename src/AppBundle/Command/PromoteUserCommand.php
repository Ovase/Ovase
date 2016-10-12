<?php
// src/AppBundle/Command/PromoteUserCommand.php
namespace AppBundle\Command;

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
		// outputs multiple lines to the console (adding "\n" at the end of each line)
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
			$output->write('That user is in another castle. Bye!\n');
			return;
		}

		// outputs a message followed by a "\n"
		$output->writeln('Howdy, partner!');

		// outputs a message without adding a "\n" at the end of the line
		$output->write('You are about to ');
		$output->write("do sum'thin' BAD.\n");
		$output->write('\n');
		$helper = $this->getHelper('question');

		$rolequestion = new ChoiceQuestion(
			'Please select the user role (defaults to USER)',
			array("ROLE_GUEST", "ROLE_USER","ROLE_EDITOR"),
			0
		);
		$rolequestion->setErrorMessage('Role %s is invalid.');

		// Assuming valid role 
		$role = $helper->ask($input, $output, $rolequestion);
		$output->writeln('You have just selected: '.$role);
		if ($role == "ROLE_GUEST") {
			$user->setIsActive(0); // YOU SHALL NOT PASS!!!...
			if (!in_array("ROLE_GUEST", $user->getRoles())) {
				$user->addRole("ROLE_GUEST");
			}
			if (in_array("ROLE_USER", $user->getRoles())) {
				$user->removeRole("ROLE_USER");
			}
			if (in_array("ROLE_EDITOR", $user->getRoles())) {
				$user->removeRole("ROLE_EDITOR");
			}
		}
		else if ($role == "ROLE_USER") {
			$user->setIsActive(1); // For now, you may pass...
			if (!in_array("ROLE_GUEST", $user->getRoles())) {
				$user->addRole("ROLE_GUEST");
			}
			if (!in_array("ROLE_USER", $user->getRoles())) {
				$user->addRole("ROLE_USER");
			}
			if (in_array("ROLE_EDITOR", $user->getRoles())) {
				$user->removeRole("ROLE_EDITOR");
			}
		}
		else if ($role == "ROLE_EDITOR") {
			$user->setIsActive(1); // For now, you may pass...
			if (!in_array("ROLE_GUEST", $user->getRoles())) {
				$user->addRole("ROLE_GUEST");
			}
			if (!in_array("ROLE_USER", $user->getRoles())) {
				$user->addRole("ROLE_USER");
			}
			if (!in_array("ROLE_EDITOR", $user->getRoles())) {
				$user->addRole("ROLE_EDITOR");
			}
		}
		else { return; }
		$em->persist($user);
		$em->flush();
		$em->close();
		$output->write('\n');
		$output->write('Bye!\n');
	}
}