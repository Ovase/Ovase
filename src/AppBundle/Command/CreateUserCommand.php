<?php
// src/AppBundle/Command/CreateUserCommand.php
namespace AppBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateUserCommand extends Command
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
        // ...
    }
}