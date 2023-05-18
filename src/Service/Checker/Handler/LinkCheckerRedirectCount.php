<?php

namespace App\Service\Checker\Handler;

class LinkCheckerRedirectCount extends BaseLinkChecker
{

    const ACTION_NAME = 'action-redirect-count';

    public function handleCheck(): string
    {
        return '2';
    }

}