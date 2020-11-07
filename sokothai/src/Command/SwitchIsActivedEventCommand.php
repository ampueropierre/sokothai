<?php

namespace App\Command;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Entity\Event;

class SwitchIsActivedEventCommand extends Command
{
    public $entityManager;

    protected static $defaultName = 'app:switch-event';

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;

        parent::__construct();
    }

    protected function configure()
    {
        $this->setDescription('Switch attribute IsActived to false when the date is passed');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $events = $this->entityManager->getRepository(Event::class)->findAllCreatedAtPassed(new \DateTime());

        $i = 0;
        foreach($events as $event) {
            $event->setIsActived(false);
            $this->entityManager->flush();
            $i++;
        }

        $s = ($i > 1) ? 's' : '';

        $output->writeln("{$i} event{$s} has been modified");

        return Command::SUCCESS;
    }
}