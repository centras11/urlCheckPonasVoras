<?php

namespace App\Command;

use App\Manager\Checker\CronLogCheckerManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Exception;

class CronCommand extends Command
{
    const CHECK_LINKS = 'check-links';

    public function __construct(
        private readonly CronLogCheckerManager $cronLogCheckerManager
    ) {

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName('cron')
            ->addArgument('type', InputArgument::OPTIONAL, 'Which type of cron do you want to run?')
            ->addArgument('limit', InputArgument::OPTIONAL, 'Limit');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $sendType = $input->getArgument('type');

        if ($sendType == self::CHECK_LINKS) {
            $this->cronLogCheckerManager->execute();
        }

        return Command::SUCCESS;
    }
}