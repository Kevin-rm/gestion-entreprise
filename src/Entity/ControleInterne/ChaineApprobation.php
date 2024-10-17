<?php

namespace App\Entity\ControleInterne;

use App\Entity\Generic\AbstractPrefixedIdEntity;
use App\Repository\ControleInterne\ChaineApprobationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChaineApprobationRepository::class)]
class ChaineApprobation extends AbstractPrefixedIdEntity
{
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: "id_niveau_validation", nullable: false)]
    private ?NiveauValidation $niveauValidation = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateHeureValidation = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $commentaire = null;

    public function getNiveauValidation(): ?NiveauValidation
    {
        return $this->niveauValidation;
    }

    public function setNiveauValidation(?NiveauValidation $niveauValidation): static
    {
        $this->niveauValidation = $niveauValidation;

        return $this;
    }

    public function getDateHeureValidation(): ?\DateTimeInterface
    {
        return $this->dateHeureValidation;
    }

    public function setDateHeureValidation(\DateTimeInterface $dateHeureValidation): static
    {
        $this->dateHeureValidation = $dateHeureValidation;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(?string $commentaire): static
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getPrefix(): string
    {
        return "CHAPPR";
    }

    public function getSequenceName(): string
    {
        return "ID_CHAINE_APPROBATION_SEQ";
    }
}
