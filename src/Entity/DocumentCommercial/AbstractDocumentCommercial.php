<?php

namespace App\Entity\DocumentCommercial;

use App\Entity\Generic\AbstractPrefixedIdEntity;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Persistence\Mapping\ClassMetadata;

#[ORM\MappedSuperclass]
abstract class AbstractDocumentCommercial extends AbstractPrefixedIdEntity
{
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    protected ?DateTimeInterface $dateHeure = null;

    /**
     * @var Collection<int, DetailsDocumentCommercial>
     */
    #[ORM\OneToMany(targetEntity: DetailsDocumentCommercial::class, mappedBy: 'documentCommercial', orphanRemoval: true)]
    private Collection $details;

    public function __construct()
    {
        $this->details = new ArrayCollection();
    }

    public function getDateHeure(): ?DateTimeInterface
    {
        return $this->dateHeure;
    }

    public function setDateHeure(?DateTimeInterface $dateHeure): static
    {
        $this->dateHeure = $dateHeure;

        return $this;
    }

    /**
     * @return Collection<int, DetailsDocumentCommercial>
     */
    public function getDetails(): Collection
    {
        return $this->details;
    }

    public function addDetail(DetailsDocumentCommercial $detail): static
    {
        if (!$this->details->contains($detail)) {
            $this->details->add($detail);
            $detail->setDocumentCommercial($this);
        }

        return $this;
    }

    public function removeDetail(DetailsDocumentCommercial $detail): static
    {
        if ($this->details->removeElement($detail)) {
            // set the owning side to null (unless already changed)
            if ($detail->getDocumentCommercial() === $this) {
                $detail->setDocumentCommercial(null);
            }
        }

        return $this;
    }
}
