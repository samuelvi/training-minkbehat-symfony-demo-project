<?php
namespace AppBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

// DEV TEST: bin/console demo:test:email --env=test
class TestEmailCommand extends ContainerAwareCommand
{
    protected $env;

    protected function configure()
    {
        $this->setName('demo:test:email')
            ->setDescription("Test e-mail")
            ->setHelp("Test e-mail");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();

        $from = 'samuelvicent@gmail.com';
        $to = 'samuelvicent@gmail.com';

        /** @var \Swift_Message $message */
        $message = \Swift_Message::newInstance()
            ->setSubject('E-mail send test from demo project')
            ->setFrom($from)
            ->setTo($to)
            ->setBody(
                'E-mail send test from demo project'
            );

        // $mailer = $container->get('swiftmailer.mailer');
        $mailer = $container->get('swiftmailer.mailer.default');
        $sendResponse = $mailer->send($message);

        $spool = $mailer->getTransport()->getSpool();
        $transport = $container->get('swiftmailer.transport.real');
        $spool->flushQueue($transport);

        echo "Respuesta de mailer: $sendResponse" . PHP_EOL;
    }

}