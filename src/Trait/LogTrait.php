<?php

namespace App\Trait;

use Doctrine\ORM\Mapping as ORM;

trait LogTrait
{
    #[ORM\Column(type: 'string', length: 190)]
    private string $action;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $value = null;

    public function getAction(): ?string
    {
        return $this->action;
    }

    public function setAction(string $action): self
    {
        $this->action = $action;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(?string $value): self
    {
        $this->value = $value;

        return $this;
    }
}