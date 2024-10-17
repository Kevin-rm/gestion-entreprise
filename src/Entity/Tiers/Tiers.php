<?php

namespace App\Entity\Tiers;

use App\Entity\Generic\AbstractPrefixedIdEntity;
use App\Enum\TypeTiers;
use App\Repository\Tiers\TiersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;

#[ORM\Entity(repositoryClass: TiersRepository::class)]
class Tiers extends AbstractPrefixedIdEntity
{
    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(enumType: TypeTiers::class)]
    private ?TypeTiers $type = null;

    /**
     * @var Collection<int, Antecedent>
     */
    #[ORM\ManyToMany(targetEntity: Antecedent::class, inversedBy: 'tiers')]
    #[ORM\JoinTable(
        joinColumns:        new JoinColumn(name: "id_tiers"),
        inverseJoinColumns: new JoinColumn(name: "id_antecedent")
    )]
    private Collection $antecedents;

    public function __construct()
    {
        $this->antecedents = new ArrayCollection();
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getType(): ?TypeTiers
    {
        return $this->type;
    }

    public function setType(TypeTiers $type): static
    {
        $this->type = $type;

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

    public function getPrefix(): string
    {
        return "TIERS";
    }

    public function getSequenceName(): string
    {
        return "ID_TIERS_SEQ";
    }
}
