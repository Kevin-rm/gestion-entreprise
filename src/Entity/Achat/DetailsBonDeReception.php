<?php

namespace App\Entity\Achat;

use App\Entity\DocumentCommercial\AbstractDocumentCommercial;
use App\Entity\DocumentCommercial\DetailsDocumentCommercial;
use App\Repository\Achat\DetailsBonDeReceptionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DetailsBonDeReceptionRepository::class)]
class DetailsBonDeReception extends DetailsDocumentCommercial
{
    #[ORM\ManyToOne(inversedBy: 'detailsBonDeReceptions')]
    #[ORM\JoinColumn(name: "id_bon_de_reception", nullable: false)]
    private ?BonDeReception $bonDeReception = null;

    public function getDocumentCommercial(): ?AbstractDocumentCommercial
    {
        return $this->bonDeReception;
    }

    public function setDocumentCommercial(?AbstractDocumentCommercial $documentCommercial): static
    {
        $this->bonDeReception = $documentCommercial;

        return $this;
    }

    public function getPrefix(): string
    {
        return "DETBR";
    }

    public function getSequenceName(): string
    {
        return "ID_DETAILS_BON_DE_RECEPTION_SEQ";
    }
}
