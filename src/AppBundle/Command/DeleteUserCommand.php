<?php
// src/AppBundle/Command/DeleteUserCommand.php
namespace AppBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use AppBundle\Entity\User;

class DeleteUserCommand extends ContainerAwareCommand
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
		// outputs multiple lines to the console (adding "\n" at the end of each line)
		$output->writeln([
			'User Role delete',
			'============',
			'',
		]);

		// outputs a message followed by a "\n"
		$output->writeln('Howdy, partner!');

		// outputs a message without adding a "\n" at the end of the line
		$output->write('Now, we gonna ');
		$output->write("do sum'thin' BAD.\n");
		$output->write('\n');

		$em = $this->getContainer()->get('doctrine')->getEntityManager();
		$user = null;
		try {
			$user = $em->getRepository("AppBundle:User")->findUserByEmail($input->getArgument('username'));
		} catch (NoResultException $t) {
			$output->write('That user is in another castle. Bye!\n');
			$em->flush();
			$output->write('\n');
			return;
		}
		try {
			$em->remove($user);
		} catch (Exception $t) {
			var_dump($t);
			$output->write('\n');
			$em->flush();
			$output->write('\n');
			$output->write('that is all. Bye!\n');
			return;
		}
		$em->flush();
		$output->write('\n');
		$output->write('Bye!\n');
    }
}