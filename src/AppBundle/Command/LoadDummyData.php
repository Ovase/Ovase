<?php
// src/AppBundle/Command/LoadDummyDataCommand.php
namespace AppBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

class LoadDummyDataCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
        // the name of the command (the part after "app/console")
        ->setName('app:load-test-data')

        // the short description shown while running "php app/console list"
        ->setDescription('For devs: Automatically load test data required by tests into Doctrine.')

        // the full command description shown when running the command with
        // the "--help" option
        ->setHelp("This command allows you to create and persist one new user...");
	}

    protected function execute(InputInterface $input, OutputInterface $output)
    {
		// Prohibit command from executing unless we are in the test environment
		$env = $this->getContainer()->get('app.environment');
		if (($env != 'dev') || ($env != 'test')) { return; }
		// outputs multiple lines to the console (adding "\n" at the end of each line)
		$output->writeln([
			'Injecting test data into database. A similar command for removing this data exists too.',
			'============',
			'',
		]);

		// outputs a message followed by a "\n"
		$output->writeln('Howdy, partner!');

		// outputs a message without adding a "\n" at the end of the line
		$output->write("Let's load some test data!\n");

		// Entity Manager
        $em = $this->getContainer()->get('doctrine');

		// Creating test users.
		$guestuser = $this->createUser('petjo@ovase.no', 'Johansen-Gjest', 'Peter', '48562021', 'feyrlodWhaLe', "ROLE_GUEST");
		$em->persist($guestuser); // Comment out?

		$em->flush();
		$em->close();
		$output->write('\n');
		$output->writeln('Bye!');
		// WARNING: DO NOT RUN IN prod-mode. Mainly ment for devs ;)
	}

    private function createUser($email, $lastName, $firstName, $phone, $plainpass, $role) {
		$user = new User();

		$salt = null;
		$isSecure = 0;
		$ATTEMPTS_LIMIT = 999; // fail-safe for infinite loop

		while (!$isSecure && $ATTEMPTS_LIMIT > 0) {
			$salt = bin2hex(openssl_random_pseudo_bytes(32, $isSecure));
			$ATTEMPTS_LIMIT--;
		}

		$pass_hash = $this->getContainer()->get('security.encoder_factory')->getEncoder(User::class)->encodePassword($plainpass, $salt);
		$user->setEmail($email);
		$user->setFirstName($firstName);
		$user->setLastName($lastName);
		$user->setPhone($phone);
		$user->setPassword($pass_hash);
		$user->setSalt($salt);
		$user->addRole($role);
		if ($role == "ROLE_GUEST") {$user->setIsActive(0);}
		else { $user->setIsActive(1); }
    	return $user;
    }
}
