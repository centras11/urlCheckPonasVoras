<?php

namespace App\Service\Checker;

use App\Entity\Link;
use App\Interface\Checker\CheckerInterface;
use App\Service\Checker\Handler\LinkCheckerRedirectCount;
use App\Service\Checker\Handler\LinkCheckerResponseCode;
use App\Service\Checker\Handler\LinkCheckerTextScraper;

class CheckerHandler
{

    private array $checkers;

    public function __construct(
        LinkCheckerTextScraper $checkerTextScraper,
        LinkCheckerRedirectCount $checkerRedirectCount,
        LinkCheckerResponseCode $checkerResponseCode,
    ) {
        $this->checkers = [
            $checkerTextScraper,
            $checkerRedirectCount,
            $checkerResponseCode
        ];
    }

    public function checkLink(Link $link)
    {
        /**
         * @var CheckerInterface $checker
         */
        foreach ($this->checkers as $checker) {
            if ($checker instanceof CheckerInterface) {
                $checker->setLink($link);
                $checker->handle();
            }
        }
    }
}