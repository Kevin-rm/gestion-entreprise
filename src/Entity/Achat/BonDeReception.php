<?php

namespace App\Entity\Achat;

use App\Entity\DocumentCommercial\AbstractDocumentCommercial;
use App\Repository\Achat\BonDeReceptionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BonDeReceptionRepository::class)]
class BonDeReception extends AbstractDocumentCommercial
{
    #[ORM\ManyToOne(inversedBy: 'bonDeReceptions')]
    #[ORM\JoinColumn(name: "id_bon_de_commande", nullable: false)]
    private ?BonDeCommande $bonDeCommande = null;

    public function getBonDeCommande(): ?BonDeCommande
    {
        return $this->bonDeCommande;
    }

    public function setBonDeCommande(?BonDeCommande $bonDeCommande): static
    {
        $this->bonDeCommande = $bonDeCommande;

        return $this;
    }

    public function getPrefix(): string
    {
        return "BR";
    }

    public function getSequenceName(): string
    {
        return "ID_BON_DE_RECEPTION_SEQ";
    }
}
