<?php

namespace App\Entity\Achat;

use App\Entity\Generic\AbstractPrefixedIdEntity;
use App\Entity\Tiers\Tiers;
use App\Entity\Utilisateur;
use App\Enum\StatusValidation;
use App\Repository\Achat\DemandeAchatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DemandeAchatRepository::class)]
class DemandeAchat extends AbstractPrefixedIdEntity
{
    #[ORM\Column(type: Types::TEXT)]
    private ?string $motif = null;

    #[ORM\ManyToOne(inversedBy: 'demandeAchats')]
    #[ORM\JoinColumn(name: "id_utilisateur", nullable: false)]
    private ?Utilisateur $utilisateur = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: "fournisseur", nullable: false)]
    private ?Tiers $fournisseur = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateHeure = null;

    #[ORM\Column(enumType: StatusValidation::class)]
    private ?StatusValidation $statusValidation = null;

    /**
     * @var Collection<int, DetailsDemandeAchat>
     */
    #[ORM\OneToMany(targetEntity: DetailsDemandeAchat::class, mappedBy: 'demandeAchat', orphanRemoval: true)]
    private Collection $detailsDemandeAchats;

    public function __construct()
    {
        $this->detailsDemandeAchats = new ArrayCollection();
    }

    public function getMotif(): ?string
    {
        return $this->motif;
    }

    public function setMotif(string $motif): static
    {
        $this->motif = $motif;

        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): static
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    public function getFournisseur(): ?Tiers
    {
        return $this->fournisseur;
    }

    public function setFournisseur(?Tiers $fournisseur): static
    {
        $this->fournisseur = $fournisseur;

        return $this;
    }

    public function getDateHeure(): ?\DateTimeInterface
    {
        return $this->dateHeure;
    }

    public function setDateHeure(\DateTimeInterface $dateHeure): static
    {
        $this->dateHeure = $dateHeure;

        return $this;
    }

    public function getStatusValidation(): ?StatusValidation
    {
        return $this->statusValidation;
    }

    public function setStatusValidation(StatusValidation $statusValidation): static
    {
        $this->statusValidation = $statusValidation;

        return $this;
    }

    /**
     * @return Collection<int, DetailsDemandeAchat>
     */
    public function getDetailsDemandeAchats(): Collection
    {
        return $this->detailsDemandeAchats;
    }

    public function addDetailsDemandeAchat(DetailsDemandeAchat $detailsDemandeAchat): static
    {
        if (!$this->detailsDemandeAchats->contains($detailsDemandeAchat)) {
            $this->detailsDemandeAchats->add($detailsDemandeAchat);
            $detailsDemandeAchat->setDemandeAchat($this);
        }

        return $this;
    }

    public function removeDetailsDemandeAchat(DetailsDemandeAchat $detailsDemandeAchat): static
    {
        if ($this->detailsDemandeAchats->removeElement($detailsDemandeAchat)) {
            // set the owning side to null (unless already changed)
            if ($detailsDemandeAchat->getDemandeAchat() === $this) {
                $detailsDemandeAchat->setDemandeAchat(null);
            }
        }

        return $this;
    }

    public function getPrefix(): string
    {
        return "DMDACHT";
    }

    public function getSequenceName(): string
    {
        return "ID_DEMANDE_ACHAT_SEQ";
    }
}
