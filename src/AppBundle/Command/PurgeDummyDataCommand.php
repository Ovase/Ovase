<?php
// src/AppBundle/Command/PurgeDummyDataCommand.php
namespace AppBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use AppBundle\Repository\UserRepository;
use AppBundle\Repository\PersonRepository;
use AppBundle\Repository\CompanyRepository;
use AppBundle\Repository\ProjectRepository;

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
		// $env = $this->getContainer()->getParameter('kernel.environment');
		// if (($env != 'dev') { return; }
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
        $em = $this->getContainer()->get('doctrine')->getManager();
        $userrepo = $em->getRepository("AppBundle:User");
        $actrepo = $em->getRepository("AppBundle:Actor");
        $projrepo = $em->getRepository("AppBundle:Project");

        // Fetch test users
        $pet = $userrepo->findUserByEmail("petjo@test.test");
        $derp = $userrepo->findUserByEmail("derp@test.test");
        $anine = $userrepo->findUserByEmail("redaktor@test.test");

		// Fetch arrays of test objects
        $actors = $actrepo->findTestActors();
        $projects = $projrepo->findTestProjects();
		
        foreach ($anine->getCompanies() as $co) {
			$anine->removeCo($co);;
		}
        foreach ($derp->getCompanies() as $co) {
			$derp->removeCo($co);;
		}

        // Attempt to delete all the things
        foreach ($actors as $pe) {
            try {
                $em->remove($pe);
            } catch (\Exception $t) {
                $output->writeln($t->getMessage());
            }
        }
        foreach ($projects as $pe) {
            try {
                $em->remove($pe);
            } catch (\Exception $t) {
                $output->writeln($t->getMessage());
            }
        }
        foreach (array($pet, $derp, $anine) as $pe) {
            try {
                $em->remove($pe);
            } catch (\Exception $t) {
                $output->writeln($t->getMessage());
            }
        }

		$em->flush();
		$em->close();
		$output->write('\n');
		$output->writeln('Bye!');
		// WARNING: DO NOT RUN IN prod-mode. Mainly ment for devs ;)
	}
}
