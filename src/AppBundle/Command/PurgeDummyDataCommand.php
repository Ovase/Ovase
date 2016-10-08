<?php
// src/AppBundle/Command/PurgeDummyDataCommand.php
namespace AppBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use AppBundle\Entity\User;
use AppBundle\Entity\Person;
use AppBundle\Entity\Company;
use AppBundle\Entity\Project;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use \DateTime;

class PurgeDummyDataCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
        // the name of the command (the part after "app/console")
        ->setName('app:purge-test-data')

        // the short description shown while running "php app/console list"
        ->setDescription('For devs: Automatically delete ALL test data objects required by tests.')

        // the full command description shown when running the command with
        // the "--help" option
        ->setHelp("This command deletes all test objects used by our tests");
	}

    protected function execute(InputInterface $input, OutputInterface $output)
    {
		// Prohibit command from executing unless we are in the test environment
		$env = $this->getContainer()->get('app.environment');
		if (($env != 'dev') || ($env != 'test')) { return; }
		// outputs multiple lines to the console (adding "\n" at the end of each line)
		$output->writeln([
			'Purging test data. Stand by.',
			'============',
			'',
		]);

		// outputs a message followed by a "\n"
		$output->writeln('Howdy, partner!');

		// outputs a message without adding a "\n" at the end of the line
		$output->write("KILL ALL THE TEST DATAS!\n");

		// Entity Manager
        $em = $this->getContainer()->get('doctrine');
        $userrepo = $em->getRepository("AppBundle:User");
        $comprepo = $em->getRepository("AppBundle:Company");
        $projrepo = $em->getRepository("AppBundle:Project");
        $prepo = $em->getRepository("AppBundle:Person");



		$em->flush();
		$em->close();
		$output->write('\n');
		$output->writeln('Bye!');
		// WARNING: DO NOT RUN IN prod-mode. Mainly ment for devs ;)
	}
}
