<?php

namespace App\Event\CheckLink;

use App\Manager\Checker\CheckerLogManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Psr\Log\LoggerInterface;

class CheckLinkSubscriber implements EventSubscriberInterface
{

    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly CheckerLogManager $checkerLogManager,
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            CheckLinkEvent::LINK_CHECK_COMPLETED => [
                ['createCheckerLog', 10],
            ],
            CheckLinkEvent::LINK_CHECK_FAILED => [
                ['createCheckerLog', 10],
                ['createErrorLog', 1],
            ],
        ];
    }

    /**
     * @param CheckLinkEvent $event
     *
     * @return void
     */
    public function createCheckerLog(CheckLinkEvent $event)
    {
        $linkChecker = $event->getLinkChecker();
        $response = $event->getResponse();
        $exception = $event->getException();

        if ($exception) {
            $response = 'Exception : ' . $exception->getMessage();
        }

        $this->checkerLogManager->createLog($linkChecker, $response);
    }

    /**
     * @param CheckLinkEvent $event
     *
     * @return void
     */
    public function createErrorLog(CheckLinkEvent $event)
    {
        $exception = $event->getException();
        $this->logger->info($exception);
    }
}