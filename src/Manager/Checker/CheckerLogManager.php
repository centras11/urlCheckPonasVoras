<?php

namespace App\Manager\Checker;

use App\Entity\Checker\CheckerLog;
use App\Interface\Checker\CheckerInterface;
use Doctrine\Persistence\ManagerRegistry;

class CheckerLogManager
{

    public function __construct(
        public ManagerRegistry $me
    ) {
    }

    public function createLog(
        CheckerInterface $checker,
        string $value
    ): void {
        $em = $this->me->getManager();
        $log = new CheckerLog();

        $log->setAction($checker->getAction());
        $log->setValue($value);
        $log->setLink($checker->getLink());
        $em->persist($log);
        $em->flush();
    }
}