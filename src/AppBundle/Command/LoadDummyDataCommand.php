<?php
// src/AppBundle/Command/LoadDummyDataCommand.php
namespace AppBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use AppBundle\Entity\User;
use AppBundle\Entity\Person;
use AppBundle\Entity\Company;
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

		// Creating test users for testing authorization
		$guestuser = $this->createUser('petjo@ovase.no', 'Johansen-Gjest', 'Peter', '48562021', 'feyrlodWhaLe', "ROLE_GUEST");
        $plainuser = $this->createUser('derp@ovase.no', 'Bruker', 'Ny', '72171642', '_Dx9QZQSVXgzkj4$', "ROLE_USER");
        $editoruser = $this->createUser('redaktor@ovase.no', 'Drageset', 'Anine', '73075003 ', '-PWbZT9a%wScj&z$', "ROLE_EDITOR");
        // Define a couple of Person Actor thingies

        $em->persist($guestuser);
        $em->persist($plainuser);
        $em->persist($editoruser);

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
		$ATTEMPTS_LIMIT = 9999; // fail-safe for infinite loop

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
    private function createActor($lastName, $firstName, $phone, $kkArr, $field, $locTupl, $email) {
        $p = new Person();

        $p->setLastName($lastName);
        $p->setFirstName($firstName);
        $p->setEmail($email);
        $p->setTlf($phone);
        $p->setKeyKnowledges($kkArr);
        $p->setLocation($locTupl);
        $p->setField($field);

        return $p;
    }
    private function createCompany($name, $type, $orgnr, $phone, $kkArr, $field, $locTupl, $email) {
        $p = new Company();

        $p->setName($name);
        $p->setOrgNr($orgnr);
        $p->setType($type);
        $p->setField($field);
        $p->setEmail($email);
        $p->setTlf($phone);
        $p->setKeyKnowledges($kkArr);
        $p->setLocation($locTupl);

        return $p;
    }
}
