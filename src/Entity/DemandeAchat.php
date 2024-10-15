<?php

namespace App\Entity;

use App\Entity\Generic\AbstractPrefixedIdEntity;
use App\Repository\DemandeAchatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DemandeAchatRepository::class)]
class DemandeAchat extends AbstractPrefixedIdEntity
{
    #[ORM\ManyToOne(inversedBy: 'demandeAchats')]
    #[ORM\JoinColumn(name: "id_utilisateur", nullable: false)]
    private ?Utilisateur $utilisateur = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: "id_fournisseur", nullable: false)]
    private ?Fournisseur $fournisseur = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateHeure = null;

    /**
     * @var Collection<int, DetailsDemandeAchat>
     */
    #[ORM\OneToMany(targetEntity: DetailsDemandeAchat::class, mappedBy: 'demandeAchat', orphanRemoval: true)]
    private Collection $detailsAchats;

    public function __construct()
    {
        $this->detailsAchats = new ArrayCollection();
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

    public function getFournisseur(): ?Fournisseur
    {
        return $this->fournisseur;
    }

    public function setFournisseur(?Fournisseur $fournisseur): static
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

    /**
     * @return Collection<int, DetailsDemandeAchat>
     */
    public function getDetailsAchats(): Collection
    {
        return $this->detailsAchats;
    }

    public function addDetailsAchat(DetailsDemandeAchat $detailsAchat): static
    {
        if (!$this->detailsAchats->contains($detailsAchat)) {
            $this->detailsAchats->add($detailsAchat);
            $detailsAchat->setDemandeAchat($this);
        }

        return $this;
    }

    public function removeDetailsAchat(DetailsDemandeAchat $detailsAchat): static
    {
        if ($this->detailsAchats->removeElement($detailsAchat)) {
            // set the owning side to null (unless already changed)
            if ($detailsAchat->getDemandeAchat() === $this) {
                $detailsAchat->setDemandeAchat(null);
            }
        }

        return $this;
    }

    function getPrefix(): string
    {
        return "DMDACHT";
    }

    function getSequenceName(): string
    {
        return "ID_DEMANDE_ACHAT_SEQ";
    }
}
