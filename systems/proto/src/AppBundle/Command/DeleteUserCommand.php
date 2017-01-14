<?php
// src/AppBundle/Command/DeleteUserCommand.php
namespace AppBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Doctrine\ORM\NoResultException;
use Exception;

class DeleteUserCommand extends ContainerAwareCommand
{
	protected function configure()
	{
		// the name of the command (the part after "app/console")
		$this->setName('app:delete-user')

		// the short description shown while running "php app/console list"
		->setDescription('Delete a user directly form the database.')
		->addArgument('username', InputArgument::REQUIRED, 'The username of the user.') // Required argument
		
		// the full command description shown when running the command with
		// the "--help" option
		->setHelp("This command allows you to delete an existing user");
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		// Prohibit command from executing unless we are in the test environment. Tip: use --env=dev
		// $env = $this->getContainer()->getParameter('kernel.environment');
		// if (($env != 'dev') { return; }
		// outputs multiple lines to the console (adding "" at the end of each line)
		$output->writeln([
			'User delete',
			'============',
			'',
		]);

		// outputs a message followed by a ""
		$output->writeln('Howdy, partner!');

		// outputs a message without adding a "" at the end of the line
		$output->write('Now, we gonna ');
		$output->write("do sum'thin' BAD.");
		$output->writeln('');

		$em = $this->getContainer()->get('doctrine')->getManager();
		$user = null;
		try {
			$user = $em->getRepository("AppBundle:User")->findUserByEmail($input->getArgument('username'));
		} catch (NoResultException $t) {
			$output->writeln('That user is in another castle. Bye!');
			$em->flush();
			$output->writeln('');
			return;
		}
		try {
			$em->remove($user);
		} catch (Exception $t) {
			var_dump($t);
			$output->writeln('');
			$em->flush();
			$output->writeln('');
			$output->writeln('that is all. Bye!');
			return;
		}
		$em->flush();
		$output->writeln('');
		$output->writeln('Bye!');
	}
}
