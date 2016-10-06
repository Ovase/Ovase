<?php
// src/AppBundle/Command/CreateUserCommand.php
namespace AppBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Question\ChoiceQuestion;
use AppBundle\Entity\User;

class CreateUserCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
        // the name of the command (the part after "app/console")
        ->setName('app:create-user')

        // the short description shown while running "php app/console list"
        ->setDescription('Create a new user.')
		
		/* Define input fields. Definition o Class - __construct(string $name, string|array $shortcut = null, integer $mode = null, string $description = '', mixed $default = null)
		->setDefinition(
                new InputDefinition(array(
                    new InputOption('foo', 'f'),
                    new InputOption('bar', 'b', InputOption::VALUE_REQUIRED),
                    new InputOption('cat', 'c', InputOption::VALUE_OPTIONAL),
                ))) */

        // the full command description shown when running the command with
        // the "--help" option
        ->setHelp("This command allows you to create and persist one new user...");
	}

    protected function execute(InputInterface $input, OutputInterface $output)
    {
    // outputs multiple lines to the console (adding "\n" at the end of each line)
    $output->writeln([
        'User Creator',
        '============',
        '',
    ]);

    // outputs a message followed by a "\n"
    $output->writeln('Howdy, partner!');

    // outputs a message without adding a "\n" at the end of the line
    $output->write('You are about to ');
    $output->write('create a user.\n');
	$output->write('\n');
    $helper = $this->getHelper('question');

	$unameq = new Question('Please enter the email of the new user ', '0');
	$lastNameq = new Question('Please enter the last name of the new user ', '0');
	$firstNameq = new Question('Please enter the first name of the new user ', '0');
	$phoneq = new Question('Please enter the phone nr of the new user ', '0');
	$passq = new Question('Please enter the password of the new user ', '0');
    $passq->setHidden(true);
    $passq->setHiddenFallback(false); /*
    $rolequestion = new ChoiceQuestion(
        'Please select the user role (defaults to USER)',
        array("ROLE_USER", "ROLE_EDITOR"),
        0
    );
    $rolequestion->setErrorMessage('Color %s is invalid.'); */
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
	$salt = null;
	$isSecure = 0;
	$ATTEMPTS_LIMIT = 999; // fail-safe for infinite loop

	while (!$isSecure && $ATTEMPTS_LIMIT > 0) {
		$salt = bin2hex(openssl_random_pseudo_bytes(32, $isSecure));
		$ATTEMPTS_LIMIT--;
	}
	$pass_hash = $this->getContainer()->get('security.encoder_factory')->getEncoder(User::class)->encodePassword($form->get('password')->getData(), $salt);
	$em = $this->getContainer()->get('app.entity_manager');
	$user = new User();
	$user->setEmail($uname);
	$user->setFirstname($firstName);
	$user->setLastname($lastName);
	$user->setPhone($phone);
	$user->setPassword($pass_hash);
	$user->setSalt($salt);
	// Authorize User as... GUEST, because laziness.
	$user->addRole("ROLE_GUEST");
	$user->setIsActive(0); // For now, you may NOT pass...
	//$em = $this->getContainer()->getDoctrine()->getManager();
	$em->persist($user);
	$em->flush();
	$output->write('\n');
	$output->writeln('Bye!');
    }
}