<?php

namespace App\Service\Checker\Handler;

use App\Entity\Link;
use App\Event\CheckLink\CheckLinkEvent;
use App\Interface\Checker\CheckerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class BaseLinkChecker implements CheckerInterface
{

    const ACTION_NAME = 'base';

    private Link $link;

    public function __construct(
        private readonly EventDispatcherInterface $eventDispatcher,
        public TranslatorInterface $translator,
        public HttpClientInterface $client
    ) {

    }

    public function getLink(): Link
    {
        return $this->link;
    }

    public function setLink(Link $link)
    {
        $this->link = $link;
    }

    public function getAction()
    {
        return static::ACTION_NAME;
    }

    public function handle()
    {
        try {
            $response = $this->handleCheck();

            $checkEvent = new CheckLinkEvent($this, $response);
            $this->eventDispatcher->dispatch($checkEvent, CheckLinkEvent::LINK_CHECK_COMPLETED);
        } catch (\Exception $e) {
            $checkEvent = new CheckLinkEvent($this, '', $e);
            $this->eventDispatcher->dispatch($checkEvent, CheckLinkEvent::LINK_CHECK_FAILED);
        }
    }

    protected function handleCheck(): string
    {
        return '';
    }
}