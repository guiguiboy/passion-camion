<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class AppTweetCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:tweet')
            ->setDescription('Sends a truck picture on Twitter. Useful.')
            ->addArgument('argument', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $result = $this->getContainer()->get(\AppBundle\Services\TruckSender::class)->send();

        if (!$result) {
            $output->writeln('The image could not be sent. Fix this immediately !');
        } else {
            $output->writeln('Successfully sent the image ! Now get back to work !');
        }
    }
}
