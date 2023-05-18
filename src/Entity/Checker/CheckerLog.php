<?php

namespace App\Entity\Checker;

use App\Entity\Link;
use App\Repository\Checker\CheckerLogRepository;
use App\Trait\BaseEntityTrait;
use App\Trait\LogTrait;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CheckerLogRepository::class)]
#[ORM\HasLifecycleCallbacks]
class CheckerLog
{
    use BaseEntityTrait, LogTrait;

    const LINK_PAGINATION = 10;

    #[ORM\ManyToOne(inversedBy: 'checkerLogs')]
    private ?Link $link = null;

    public function getLink(): ?Link
    {
        return $this->link;
    }

    public function setLink(?Link $link): self
    {
        $this->link = $link;

        return $this;
    }
}
