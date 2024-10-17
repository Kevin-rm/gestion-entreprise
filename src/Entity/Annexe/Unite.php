<?php

namespace App\Entity\Annexe;

use App\Entity\Generic\AbstractPrefixedIdEntity;
use App\Repository\Annexe\UniteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UniteRepository::class)]
class Unite extends AbstractPrefixedIdEntity
{
    #[ORM\Column(length: 255)]
    private ?string $designation = null;

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): static
    {
        $this->designation = $designation;

        return $this;
    }

    public function getPrefix(): string
    {
        return "UNIT";
    }

    public function getSequenceName(): string
    {
        return "ID_UNITE_SEQ";
    }
}
