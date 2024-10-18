<?php

namespace App\Service;

use App\Entity\Stock\MouvementStock;
use App\Entity\Stock\DetailsMouvementStock;
use App\Entity\Annexe\Produit;
use App\Enum\TypeMouvementStock;

use Doctrine\ORM\EntityManagerInterface;

class ServiceDetail
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * 
     * @param Produit $produit
     * @param string $method (FIFO, LIFO, etc.)
     * @return float
     */
    public function calculerValeurStock(Produit $produit, string $method = 'FIFO'): float
    {
        // Récupérer tous les mouvements de stock pour ce produit
        $mouvements = $this->getMouvementsStockByProduit($produit);

        // Appliquer la méthode de valorisation choisie
        switch (strtoupper($method)) {
            case 'LIFO':
                return $this->calculerValeurStockLIFO($mouvements);
            case 'FIFO':
            default:
                return $this->calculerValeurStockFIFO($mouvements);
        }
    }

    /**
     * Récupère les mouvements de stock pour un produit spécifique.
     *
     * @param Produit $produit
     * @return MouvementStock[]
     */
    private function getMouvementsStockByProduit(Produit $produit): array
    {
        return $this->em->getRepository(MouvementStock::class)
            ->findBy(['produit' => $produit], ['dateHeur' => 'ASC']);
    }

    /**
     * Calcule la valeur du stock selon la méthode FIFO (First In, First Out).
     *
     * @param MouvementStock[] $mouvements
     * @return float
     */
    private function calculerValeurStockFIFO(array $mouvements): float
    {
        $valeurTotale = 0.0;

        foreach ($mouvements as $mouvement) {
            $detailsMouvements = $this->em->getRepository(DetailsMouvementStock::class)
                ->findBy(['mouvementStock' => $mouvement]);

            foreach ($detailsMouvements as $detail) {
                $typeMouvement = $mouvement->getTypeMouvementStock();
                
                if ($typeMouvement === TypeMouvementStock::ENTREE) {
                    $valeurTotale += $detail->getQuantite() * $detail->getPrixUnitaire();
                } elseif ($typeMouvement === TypeMouvementStock::SORTIE) {
                    $valeurTotale -= $detail->getQuantite() * $detail->getPrixUnitaire();
                }
            }
        }

        return $valeurTotale;
    }

    /**
     *
     * @param MouvementStock[] $mouvements
     * @return float
     */
    private function calculerValeurStockLIFO(array $mouvements): float
    {
        $valeurTotale = 0.0;
        $quantiteEnStock = 0;

        // Inverser les mouvements pour appliquer LIFO
        $mouvements = array_reverse($mouvements);

        foreach ($mouvements as $mouvement) {
            $detailsMouvements = $this->em->getRepository(DetailsMouvementStock::class)
                ->findBy(['mouvementStock' => $mouvement]);

            foreach ($detailsMouvements as $detail) {
                $typeMouvement = $mouvement->getTypeMouvementStock();
                
                if ($typeMouvement === TypeMouvementStock::ENTREE) {
                    $quantiteEnStock += $detail->getQuantite();
                    $valeurTotale += $detail->getQuantite() * $detail->getPrixUnitaire();
                } elseif ($typeMouvement === TypeMouvementStock::SORTIE) {
                    $quantiteEnStock -= $detail->getQuantite();
                }
            }
        }

        return $quantiteEnStock > 0 ? $valeurTotale / $quantiteEnStock : 0;
    }
}
