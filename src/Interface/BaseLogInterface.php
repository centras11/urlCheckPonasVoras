<?php

namespace App\Interface;

interface BaseLogInterface
{
    public function getAction(): ?string;

    public function setAction(string $action): self;

    public function getValue(): ?string;

    public function setValue(?string $value): self;
}