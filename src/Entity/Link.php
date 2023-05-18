<?php

namespace App\Entity;

use App\Entity\Checker\CheckerLog;
use App\Interface\BaseEntityInterface;
use App\Repository\LinkRepository;
use App\Trait\BaseEntityTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LinkRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Link implements BaseEntityInterface
{
    use BaseEntityTrait;

    const LINK_PAGINATION = 10;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $url = null;

    #[ORM\ManyToOne(inversedBy: 'links')]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'link', targetEntity: CheckerLog::class)]
    private Collection $checkerLogs;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $scrapeText = null;

    public function __construct()
    {
        $this->checkerLogs = new ArrayCollection();
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, CheckerLog>
     */
    public function getCheckerLogs(): Collection
    {
        return $this->checkerLogs;
    }

    public function addCheckerLog(CheckerLog $checkerLog): self
    {
        if (!$this->checkerLogs->contains($checkerLog)) {
            $this->checkerLogs->add($checkerLog);
            $checkerLog->setLink($this);
        }

        return $this;
    }

    public function removeCheckerLog(CheckerLog $checkerLog): self
    {
        if ($this->checkerLogs->removeElement($checkerLog)) {
            // set the owning side to null (unless already changed)
            if ($checkerLog->getLink() === $this) {
                $checkerLog->setLink(null);
            }
        }

        return $this;
    }

    public function getScrapeText(): ?string
    {
        return $this->scrapeText;
    }

    public function setScrapeText(?string $scrapeText): self
    {
        $this->scrapeText = $scrapeText;

        return $this;
    }
}
