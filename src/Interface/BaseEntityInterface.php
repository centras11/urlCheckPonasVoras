<?php
declare(strict_types = 1);

namespace App\Interface;

use DateTimeImmutable;

interface BaseEntityInterface
{
    public function getId(): ?int;

    public function getCreatedAt(): ?DateTimeImmutable;

    public function setCreatedAt(?DateTimeImmutable $createdAt): self;

    public function getUpdatedAt(): ?DateTimeImmutable;

    public function setUpdatedAt(?DateTimeImmutable $updatedAt): self;
}