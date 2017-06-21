<?php

namespace AppBundle\Command;

use AppBundle\Service\User as UserService;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class CreateUserCommand extends ContainerAwareCommand
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('fos:user:create')
            ->setDescription('Create a user.')
            ->setDefinition(array(
                    new InputArgument('username', InputArgument::REQUIRED, 'The username'),
                    new InputArgument('email', InputArgument::REQUIRED, 'The email'),
                    new InputArgument('password', InputArgument::REQUIRED, 'The password'),
                    new InputArgument('first_name', InputArgument::REQUIRED, 'The first name'),
                    new InputArgument('last_name', InputArgument::REQUIRED, 'The last name'),
                    new InputOption('super-admin', null, InputOption::VALUE_NONE, 'Set the user as super admin'),
                    new InputOption('inactive', null, InputOption::VALUE_NONE, 'Set the user as inactive'),
                )
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $username = $input->getArgument('username');
        $email = $input->getArgument('email');
        $password = $input->getArgument('password');
        $firstName = $input->getArgument('first_name');
        $lastName = $input->getArgument('last_name');
        $inactive = $input->getOption('inactive');
        $superadmin = $input->getOption('super-admin');

        /** @var UserService $userService */
        $userService = $this->getContainer()->get('app.service.user');

        $userService->createUserFromCommandLine($username, $password, $email, $firstName, $lastName, !$inactive, $superadmin);

        $output->writeln(sprintf('Created user <comment>%s</comment>', $username));
    }

}
