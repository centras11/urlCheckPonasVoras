<?php

namespace App\Event\CheckLink;

use App\Interface\Checker\CheckerInterface;
use Symfony\Contracts\EventDispatcher\Event;

class CheckLinkEvent extends Event
{

    const LINK_CHECK_COMPLETED = 'link_check.completed';
    const LINK_CHECK_FAILED = 'link_check.failed';

    public function __construct(
        private CheckerInterface $checker,
        private string $response,
        private ?\Exception $exception = null)
    {
    }

    public function getLinkChecker(): CheckerInterface
    {
        return $this->checker;
    }

    public function getResponse(): string
    {
        return $this->response;
    }

    public function getException()
    {
        return $this->exception;
    }

}