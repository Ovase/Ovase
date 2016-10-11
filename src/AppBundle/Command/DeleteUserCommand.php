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
        ->setHelp("This command allows you to change the authorization of someone...");
	}

    protected function execute(InputInterface $input, OutputInterface $output)
    {
                // Prohibit command from executing unless we are in the test environment
                $env = $this->getContainer()->getParameter('kernel.environment');
                if (($env != 'dev')) { return; }
		// outputs multiple lines to the console (adding "\n" at the end of each line)
		$output->writeln([
			'User delete',
			'============',
			'',
		]);

		// outputs a message followed by a "\n"
		$output->writeln('Howdy, partner!');

		// outputs a message without adding a "\n" at the end of the line
		$output->write('Now, we gonna ');
		$output->write("do sum'thin' BAD.\n");
		$output->write('\n');

        $em = $this->getContainer()->get('doctrine')->getManager();
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
