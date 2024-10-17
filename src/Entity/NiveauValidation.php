<?php

namespace App\Entity;

use App\Entity\Generic\AbstractPrefixedIdEntity;
use App\Repository\NiveauValidationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NiveauValidationRepository::class)]
class NiveauValidation extends AbstractPrefixedIdEntity
{
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $tache = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: "approbateur", nullable: false)]
    private ?Utilisateur $approbateur = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $ordre = null;

    public function getTache(): ?string
    {
        return $this->tache;
    }

    public function setTache(?string $tache): static
    {
        $this->tache = $tache;

        return $this;
    }

    public function getApprobateur(): ?Utilisateur
    {
        return $this->approbateur;
    }

    public function setApprobateur(?Utilisateur $approbateur): static
    {
        $this->approbateur = $approbateur;

        return $this;
    }

    public function getOrdre(): ?int
    {
        return $this->ordre;
    }

    public function setOrdre(int $ordre): static
    {
        $this->ordre = $ordre;

        return $this;
    }

    public function getPrefix(): string
    {
        return "NIVVAL";
    }

    public function getSequenceName(): string
    {
        return "ID_NIVEAU_VALIDATION_SEQ";
    }
}
