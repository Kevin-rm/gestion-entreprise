<?php

namespace App\Entity;

use App\Entity\Generic\AbstractPrefixedIdEntity;
use App\Repository\FournisseurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FournisseurRepository::class)]
class Fournisseur extends AbstractPrefixedIdEntity
{
    #[ORM\Column(length: 255)]
    private ?string $nomEntreprise = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    /**
     * @var Collection<int, Antecedent>
     */
    #[ORM\ManyToMany(targetEntity: Antecedent::class, inversedBy: 'fournisseurs')]
    private Collection $antecedents;

    public function __construct()
    {
        $this->antecedents = new ArrayCollection();
    }

    public function getNomEntreprise(): ?string
    {
        return $this->nomEntreprise;
    }

    public function setNomEntreprise(string $nomEntreprise): static
    {
        $this->nomEntreprise = $nomEntreprise;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection<int, Antecedent>
     */
    public function getAntecedents(): Collection
    {
        return $this->antecedents;
    }

    public function addAntecedent(Antecedent $antecedent): static
    {
        if (!$this->antecedents->contains($antecedent)) {
            $this->antecedents->add($antecedent);
        }

        return $this;
    }

    public function removeAntecedent(Antecedent $antecedent): static
    {
        $this->antecedents->removeElement($antecedent);

        return $this;
    }

    function getPrefix(): string
    {
        return "FRN";
    }

    function getSequenceName(): string
    {
        return "ID_FOURNISSEUR_SEQ";
    }
}
