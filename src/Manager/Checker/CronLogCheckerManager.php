<?php

namespace App\Manager\Checker;

use App\Entity\Link;
use App\Service\Checker\CheckerHandler;
use Doctrine\ORM\EntityManagerInterface;

class CronLogCheckerManager
{

    private CheckerHandler $checkerHandler;

    private EntityManagerInterface $em;

    public function __construct(
        CheckerHandler $checkerHandler,
        EntityManagerInterface $em
    )
    {
        $this->checkerHandler = $checkerHandler;
        $this->em = $em;
    }

    public function execute(): void
    {
        /**
         * @var Link $link
         */

        $items = $this->em->getRepository(Link::class)->findAll();

        foreach ($items as $link) {
            $this->checkerHandler->checkLink($link);
        }
    }
}