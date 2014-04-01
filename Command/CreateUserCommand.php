<?php



namespace Dzangocart\Bundle\CoreBundle\Command;

use Dzangocart\Bundle\CoreBundle\Model\StoreQuery;
use Dzangocart\Bundle\CoreBundle\Model\User;

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
            ->setName('dzangocart:user:create')
            ->setDescription('Create a user.')
            ->setDefinition(array(
                new InputArgument('realm', InputArgument::REQUIRED, 'The realm'),
                new InputArgument('username', InputArgument::REQUIRED, 'The username'),
                new InputArgument('password', InputArgument::REQUIRED, 'The password'),
                new InputArgument('email', InputArgument::REQUIRED, 'The email')

            ))
            ->addOption('owner', null, InputOption::VALUE_REQUIRED, 'owner');
            
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $realm      = $input->getArgument('realm');
        $username   = $input->getArgument('username');
        $password   = $input->getArgument('password');
        $email      = $input->getArgument('email');
        $isOwner    = $input->getOption('owner');

        $user = new User();

        $user->setRealm($realm);
        $user->setUsername($username);
        $user->setEmail($email);

        $user->setIsActive(1);

        $user->setPlainPassword($password);

        $this->getContainer()->get('fos_user.user_manager')->updateUser($user);

        $user->save();

        if ($isOwner == 1) {

            $owner_id = $user->getPrimaryKey();

            $store = StoreQuery::create()
                ->filterByRealm($realm)
                ->findOne();

            $store->setOwnerId($owner_id);

            $store->save();
        }

        $output->writeln(sprintf('Created user <comment>%s</comment>', $username));
    }

    protected function interact(InputInterface $input, OutputInterface $output)
    {
        if (!$input->getArgument('realm')) {
            $realm = $this->getHelper('dialog')->askAndValidate(
                $output,
                'Please indicate the realm ',
                function ($realm) {
                    return $realm;
                }
            );

            $input->setArgument('realm', $realm);
        }

        if (!$input->getArgument('username')) {
            $username = $this->getHelper('dialog')->askAndValidate(
                $output,
                'Please give the username:',
                function ($username) {
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
                function ($password) {
                    if (empty($password)) {
                        throw new \Exception('Password can not be empty');
                    }

                    return $password;
                }
            );

            $input->setArgument('password', $password);
        }

        if (!$input->getArgument('email')) {
            $email = $this->getHelper('dialog')->askAndValidate(
                $output,
                'Please enter the email',
                function ($email) {
                    if (empty($email)) {
                        throw new \Exception('email can not be empty');
                    }

                    return $email;
                }
            );

            $input->setArgument('email', $email);
        }
    }

}
