<?php
// src/AppBundle/Command/CreateUserCommand.php
namespace AppBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

class CreateUserCommand extends ContainerAwareCommand
{
	protected function configure()
	{
		$this
		// the name of the command (the part after "app/console")
		->setName('app:create-user')

		// the short description shown while running "php app/console list"
		->setDescription('Create a new user.')
		
		// the full command description shown when running the command with
		// the "--help" option
		->setHelp("This command allows you to create and persist one new user...");
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		// Prohibit command from executing unless we are in the test environment. Tip: use --env=dev
		// $env = $this->getContainer()->getParameter('kernel.environment');
		// if (($env != 'dev') { return; }
		// outputs multiple lines to the console (adding "" at the end of each line)
		$output->writeln([
			'User Creator',
			'============',
			'',
		]);

		// outputs a message followed by a ""
		$output->writeln('Howdy, partner!');

		// outputs a message without adding a "" at the end of the line
		$output->write('You are about to ');
		$output->write('create a user.');
		$output->writeln('');
		$helper = $this->getHelper('question');

		$unameq = new Question('Please enter the email of the new user ', '0');
		$lastNameq = new Question('Please enter the last name of the new user ', '0');
		$firstNameq = new Question('Please enter the first name of the new user ', '0');
		$phoneq = new Question('Please enter the phone nr of the new user ', '0');
		$passq = new Question('Please enter the password of the new user ', '0');
		$passq->setHidden(true);
		$passq->setHiddenFallback(false);
		$uname = '0';
		$lastName = '0';
		$firstName = '0';
		$phone = '0';
		$pass = '0'; // include salting and hashing code
		while ($uname === '0') {
			$uname = $helper->ask($input, $output, $unameq);
		}
		while ($firstName === '0') {
			$firstName = $helper->ask($input, $output, $firstNameq);
		}
		while ($lastName === '0') {
			$lastName = $helper->ask($input, $output, $lastNameq);
		}
		while ($phone === '0') {
			$phone = $helper->ask($input, $output, $phoneq);
		}
		while ($pass === '0') {
			$pass = $helper->ask($input, $output, $passq);
		}

		$em = $this->getContainer()->get('doctrine')->getManager();
		$user = new User();
		$user->setEmail($uname);
		$user->setFirstName($firstName);
		$user->setLastName($lastName);
		$user->setPhone($phone);
        $encoder = $this->getContainer()->get('security.password_encoder');
        $encodedPass = $encoder->encodePassword($user, $pass);
        $user->setPassword($encodedPass);
		$user->addRole("ROLE_USER");
		$user->setIsActive(1);
		$em->persist($user);
		$em->flush();
		$em->close();
		$output->writeln('');
		$output->writeln('Bye!');
		// WARNING: DO NOT RUN IN prod-mode. Mainly ment for devs ;)
	}
}
