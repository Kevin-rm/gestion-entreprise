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
            case 'CNUP':
                return $this->calculerValeurStockCnup($mouvements);
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
        // Utilisation de QueryBuilder pour faire une jointure avec les détails des mouvements
        $qb = $this->em->createQueryBuilder();

        return $qb->select('mouvement', 'detail')
            ->from(MouvementStock::class, 'mouvement')
            ->leftJoin('mouvement.detailsMouvementStock', 'detail')
            ->where('mouvement.produit = :produit')
            ->setParameter('produit', $produit)
            ->orderBy('mouvement.dateHeur', 'ASC')
            ->getQuery()
            ->getResult();
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
            $detailsMouvements = $mouvement->getDetailsMouvementStock();

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

        // Inverser les mouvements pour traiter les derniers en premier (LIFO)
        $mouvements = array_reverse($mouvements);

        foreach ($mouvements as $mouvement) {
            // Récupérer les détails du mouvement
            $detailsMouvements = $mouvement->getDetailsMouvementStock();

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
     * Calcule la valeur de stock en utilisant le Coût Normalisé Unitaire de Production (CNUP).
     *
     * @param Produit $produit
     * @return float
     */
    private function calculerValeurStockCnup(array $mouvements): float
    {
        $totalEntrees = 0.0;
        $quantiteDisponible = 0;

        foreach ($mouvements as $mouvement) {
            // Récupérer les détails des mouvements de stock
            $detailsMouvements = $mouvement->getDetailsMouvementStock();
            $typeMouvement = $mouvement->getTypeMouvementStock();

            foreach ($detailsMouvements as $detail) {
                if ($typeMouvement === TypeMouvementStock::ENTREE) {
                    $totalEntrees += $detail->getQuantite() * $detail->getPrixUnitaire();
                    $quantiteDisponible += $detail->getQuantite();
                } elseif ($typeMouvement === TypeMouvementStock::SORTIE) {
                    $quantiteDisponible -= $detail->getQuantite();
                }
            }
        }

        // Calculer la valeur de stock en utilisant le CNUP
        $cnup = $quantiteDisponible > 0 ? $totalEntrees / $quantiteDisponible : 0;

        // Valeur de stock totale
        return $quantiteDisponible * $cnup;
    }

}
