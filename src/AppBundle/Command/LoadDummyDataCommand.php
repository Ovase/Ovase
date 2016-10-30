<?php
// src/AppBundle/Command/LoadDummyDataCommand.php
namespace AppBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use AppBundle\Entity\User;
use AppBundle\Entity\Person;
use AppBundle\Entity\Company;
use AppBundle\Entity\Project;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use \DateTime;

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
		->setHelp("This command generates all dummy objects needed for the functional tests.");
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		// Prohibit command from executing unless we are in the test environment
		// $env = $this->getContainer()->getParameter('kernel.environment');
		// if (($env != 'dev') { return; }
		// outputs multiple lines to the console (adding "" at the end of each line)
		$output->writeln([
			'Injecting test data into database. A similar command for removing this data exists too.',
			'============',
			'',
		]);

		// outputs a message followed by a ""
		$output->writeln('Howdy, partner!');

		// outputs a message without adding a "" at the end of the line
		$output->writeln("Let's load some test data!");

		// Entity Manager
		$em = $this->getContainer()->get('doctrine')->getManager();

		// Creating test users for testing authorization - refer to these when logging into secured areas of KMS
		$guestuser = $this->createUser('petjo@test.test', 'Johansen-Gjest', 'Peter', '48562021', 'f1å_eyrlodWhaLe', "guest"); // Sentinel value: $email == 'petjo@ovase.no'
		$plainuser = $this->createUser('derp@test.test', 'Bruker', 'Ny', '72171642', '_Dx9åQZQSVXgzkj4$', "ROLE_USER"); // Sentinel value: 'derp@ovase.no'
		$editoruser = $this->createUser('redaktor@test.test', 'Drageset', 'Anine', '73075003', '-PWb_åZT9a%wScj&z$', "ROLE_EDITOR"); // Sentinel value: 'redaktor@ovase.no'
		// Define a couple of Person Actor thingies
		$ad = $this->createActor('Drageset', 'Anine', '73075003', array("water engineering","energy","rain gardening","spray ponds"), "TEST", "63.506144,9.20091", 'redaktor@ovase.no'); // Sentinel value: $field == "TEST"
		$gg = $this->createActor('Gundersen', 'Gunder', '55229068', array("rain gardening","spray ponds", "green roof", "skybruddsikring"), "TEST", "60.389444,5.33", 'gundersen@nulrik.no');
		$bh = $this->createActor('Holt', 'Bjørn', '23265681', array("documentation","multifunctional playground", "green roof", "stormwater on road"), "TEST", "59.95,10.75", 'fylking@osloregn.no');
		$pl = $this->createActor('Langdal', 'Peder', '73300570', array("systems administration","multifunctional playground", "green roof", "linux", "booboo"), "TEST", "63.506144, 9.20091", 'admin@ovase.no');
		$sm = $this->createActor('Multitask', 'Stine', '23186562', array("rain harvest", "documentation", "multifunctional playground", "green roof", "stormwater on road", "TEST","energy","rain gardening","spray ponds"), "public sector", array(60.389444,5.33), 'travel@nulrik.no'); // Works for all three companies??

		//Define three companies
		$ovase = $this->createCompany("OVASE", "npo", '913746830', '91376830', array("water engineering","energy","rain gardening","spray ponds","systems administration","multifunctional playground", "green roof", "linux", "kms"), "TEST", array(63.506144,9.20091), "mail@ovase.no"); // Sentinel value: $field == "TEST"
		$uncas = $this->createCompany("Ulrik N Consulting AS", "private entity", "970950446", "57095044", array("rain gardening","spray ponds", "green roof", "skybruddsikring", "bergen", "booboo"), "TEST", "60.389444, 5.33", "to@nulrik.no");
		$okr = $this->createCompany("Oslo Kommune Regnsekt", "public entity", "985808713", "23579504", array("documentation","water engineering","rain gardening","spray ponds", "green roof"), "TEST", "60.389444, 5.33", "kontakt@osloregn.no");

		// Define some projects
		$pa = $this->createProject("Grønt Tak på Operaen", "TEST", '2016-01-01', '2017-07-06', "59.906944, 10.753611", array("green roof", "salt water pollution control", "rainwater deferring"), "Dekk operaen i Bjørvika med et grønt tak for å forhindre at regnvann skylles ut i havet og oversvømmer byen. Avventer per dags dato godkjenning fra Riksantikvaren");
		$pb = $this->createProject("Multifunksjonelt lekeområde på Ulriken Oppvekstsenter ", "TEST", '2016-11-02', '2017-08-08', "60.40, 6.12", array("multifunctional playground","rainwater deferring, public cost"), "Utform eksisterende lekeareal på Ulriken Oppvekstsenter til å transportere regnvann til et naturlig fuglebasseng og samtidig utfolde lekearealet.");

        // Define relations
		$editoruser->addActor($ovase);
		$plainuser->addActor($ovase);
		$editoruser->addActor($uncas);
		$editoruser->addActor($okr);
		$ovase->addPerson($pl);
		$ovase->addPerson($ad);
		$ovase->addPerson($sm);
		$uncas->addPerson($sm);
		$uncas->addPerson($gg);
		$okr->addPerson($sm);
		$okr->addPerson($bh);
		$pa->addActor($ad);
		$pa->addActor($okr);
		$pa->addActor($sm);
		$pb->addActor($uncas);

		$em->persist($guestuser);
		$em->persist($plainuser);
		$em->persist($editoruser);
		$em->persist($gg);
		$em->persist($bh);
		$em->persist($ad);
		$em->persist($pl);
		$em->persist($sm);
		$em->persist($ovase);
		$em->persist($uncas);
		$em->persist($okr);
		$em->persist($pa);
		$em->persist($pb);

		$em->flush(); // Error when flushing
        echo("\nblod");
		$em->close();
		$output->writeln('');
		$output->writeln('Bye!');
		// WARNING: DO NOT RUN IN prod-mode. Mainly ment for devs ;)
	}

	/**
	 * Instantiates a new User and returns it.
	 * @param $email
	 * @param $lastName
	 * @param $firstName
	 * @param $phone
	 * @param $plainpass
	 * @param $role
	 * @return User
	 */
	private function createUser($email, $lastName, $firstName, $phone, $plainpass, $role) {
		$user = new User();

        $encoder = $this->getContainer()->get('security.password_encoder');
        $encodedPass = $encoder->encodePassword($user, $plainpass);
        $user->setPassword($encodedPass);

		$user->setEmail($email);
		$user->setFirstName($firstName);
		$user->setLastName($lastName);
		$user->setPhone($phone);

        if ($role == "ROLE_EDITOR") {
            $user->setRoles(array("ROLE_EDITOR", "ROLE_USER"));
            $user->setIsActive(1);
        }
        else if ($role == "ROLE_USER"){
            $user->setRoles(array("ROLE_USER"));
            $user->setIsActive(1);
        }
        else {
            $user->setIsActive(0);
        }
		return $user;
	}

	/**
	 * Instantiates a new Person and returns it.
	 * @param $lastName
	 * @param $firstName
	 * @param $phone
	 * @param $kkArr
	 * @param $field
	 * @param $locTupl
	 * @param $email
	 * @return Person
	 */
	private function createActor($lastName, $firstName, $phone, $kkArr, $field, $locTupl, $email) {
		$p = new Person();

		$p->setLastName($lastName);
		$p->setFirstName($firstName);
		$p->setEmail($email);
		$p->setTlf($phone);
		$p->setKeyKnowledges($kkArr);
		$p->setLocation($locTupl);
		$p->setField($field);

        $p->setCompetence('None');
        $p->setImage('http://publicdomainvectors.org/photos/defaultprofile.png'); // Not sure if very naive.
		return $p;
	}

	/**
	 * Instantiates a new Company and returns it.
	 * @param $name
	 * @param $type
	 * @param $orgnr
	 * @param $phone
	 * @param $kkArr
	 * @param $field
	 * @param $locTupl
	 * @param $email
	 * @return Company
	 */
	private function createCompany($name, $type, $orgnr, $phone, $kkArr, $field, $locTupl, $email) {
		$c = new Company();

		$c->setName($name);
		$c->setOrgNr($orgnr);
		$c->setType($type);
		$c->setField($field);
		$c->setEmail($email);
		$c->setTlf($phone);
		$c->setKeyKnowledges($kkArr);
		$c->setLocation($locTupl);
        $c->setCompetence('None');

		return $c;
	}

	/**
	 * Instantiates a new Project and returns it.
	 * @param $name
	 * @param $field
	 * @param $start
	 * @param $end
	 * @param $locTupl
	 * @param $techSolArr
	 * @param $desc
	 * @return Project
	 */
	private function createProject($name, $field, $start, $end, $locTupl, $techSolArr, $desc) {
		$p = new Project();
        echo($field);

		$p->setName($name);
		$p->setStartdate($start);
		$p->setEnddate($end);
		$p->setLocation($locTupl);
		$p->setTechnicalSolutions($techSolArr);
		$p->setDescription($desc);
        $p->setAreaType('default');
        $p->setCost(100.0);
        $p->setDescription('test');
        $p->setDimentionalDemands('none');
        $p->setWaterArea(1.0);
        $p->setTotalArea(2.0);
        $p->setSummary('test');
        $p->setSoilConditions('test');
        $p->setProjectType('test');

		return $p;
	}
}
