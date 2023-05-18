<?php

namespace App\Interface\Checker;

use App\Entity\Link;

interface CheckerInterface
{
    public function handle();
    public function getAction();
    public function setLink(Link $link);
    public function getLink();
}