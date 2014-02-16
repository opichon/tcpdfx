<?php

namespace Dzangocart\Bundle\CoreBundle\Command;

use \Criteria;
use \InvalidArgumentException;

use Dzangocart\Bundle\CoreBundle\Model\UserQuery;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * ChangePasswordCommand
 */
class ChangePasswordCommand extends ContainerAwareCommand
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('dzangocart:user:change-password')
            ->setDescription('Change the password of a user.')
            ->setDefinition(array(
                new InputArgument('username', InputArgument::REQUIRED, 'The username'),
                new InputArgument('password', InputArgument::REQUIRED, 'The password'),
                new InputArgument('realm', InputArgument::OPTIONAL, 'The realm')
            ))
            ->setHelp(<<<EOT
The <info>dzangocart:user:change-password</info> command changes the password of a user:

  <info>php app/console fos:user:change-password matthieu</info>

This interactive shell will first ask you for a password.

You can alternatively specify the password as a second argument:

  <info>php app/console fos:user:change-password matthieu mypassword</info>

EOT
            );
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $username = $input->getArgument('username');
        $password = $input->getArgument('password');
        $realm = $input->getArgument('realm');

        $user = $this->findUser($username, $realm);

        $user->setPlainPassword($password);
        $this->getContainer()->get('fos_user.user_manager')->updateUser($user);

        $output->writeln(sprintf('Changed password for user <comment>%s</comment> in realm <comment>%s</comment>', $username, $realm));
    }

    /**
     * @see Command
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        if (!$input->getArgument('realm')) {
            $realm = $this->getHelper('dialog')->askAndValidate(
                $output,
                'Please indicate the realm (empty for admin users):',
                function($realm) {

                    return $realm;
                }
            );

            $input->setArgument('realm', $realm);
        }

        if (!$input->getArgument('username')) {
            $username = $this->getHelper('dialog')->askAndValidate(
                $output,
                'Please give the username:',
                function($username) {
                    if (empty($username)) {
                        throw new \Exception('Username can not be empty');
                    }

                    return $username;
                }
            );

            $input->setArgument('username', $username);
        }

        if (!$input->getArgument('password')) {
            $password = $this->getHelper('dialog')->askAndValidate(
                $output,
                'Please enter the new password:',
                function($password) {
                    if (empty($password)) {
                        throw new \Exception('Password can not be empty');
                    }

                    return $password;
                }
            );

            $input->setArgument('password', $password);
        }
    }

    protected function findUser($username, $realm = null)
    {
        $user = UserQuery::create()
            ->filterByUsername($username)
            ->_if($realm)
                ->filterByRealm($realm)
            ->_else()
                ->filterByRealm(null, Criteria::ISNULL)
            ->_endIf()
            ->findOne();

        if (!$user) {
            throw new InvalidArgumentException(sprintf('User identified by "%s" username does not exist in realm %s.', $username, $realm));
        }

        return $user;
    }
}
