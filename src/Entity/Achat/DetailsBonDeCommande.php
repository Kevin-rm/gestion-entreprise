<?php

namespace App\Entity\Achat;

use App\Entity\DocumentCommercial\AbstractDocumentCommercial;
use App\Entity\DocumentCommercial\DetailsDocumentCommercial;
use App\Repository\Achat\DetailsBonDeCommandeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DetailsBonDeCommandeRepository::class)]
class DetailsBonDeCommande extends DetailsDocumentCommercial
{
    #[ORM\ManyToOne(inversedBy: 'detailsBonDeCommandes')]
    #[ORM\JoinColumn(name: "id_bon_de_commande", nullable: false)]
    private ?BonDeCommande $bonDeCommande = null;

    public function getDocumentCommercial(): ?AbstractDocumentCommercial
    {
        return $this->bonDeCommande;
    }

    public function setDocumentCommercial(?AbstractDocumentCommercial $documentCommercial): static
    {
        $this->bonDeCommande = $documentCommercial;

        return $this;
    }

    public function getPrefix(): string
    {
        return "DETBC";
    }

    public function getSequenceName(): string
    {
        return "ID_DETAILS_BON_DE_COMMANDE_SEQ";
    }
}
