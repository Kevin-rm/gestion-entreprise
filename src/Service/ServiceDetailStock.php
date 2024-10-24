<?php

namespace App\Service;

use App\Entity\Stock\MouvementStock;
use App\Entity\Stock\DetailsMouvementStock;
use App\Entity\Annexe\Produit;
use App\Enum\TypeMouvementStock;
use Doctrine\ORM\EntityManagerInterface;


class ServiceDetailStock
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function calculerValeurStock(Produit $produit, string $method = 'FIFO'): float
    {
        $mouvements = $this->getMouvementsStockByProduit($produit);

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
/*
    public function calculerValeurTotalStock(string $method = 'FIFO'): float
    {
        $produits = $this->getAllProduits(); // Méthode pour récupérer tous les produits
        $valeurTotal = 0.0;

        foreach ($produits as $produit) {
            $mouvements = $this->getMouvementsStockByProduit($produit);

            switch (strtoupper($method)) {
                case 'LIFO':
                    $valeurTotal += $this->calculerValeurStockLIFO($mouvements);
                    break;
                case 'FIFO':
                default:
                    $valeurTotal += $this->calculerValeurStockFIFO($mouvements);
                    break;
                case 'CNUP':
                    $valeurTotal += $this->calculerValeurStockCnup($mouvements);
                    break;
            }
        }

        return $valeurTotal;
    }
*/

    private function getMouvementsStockByProduit(Produit $produit): array
    {
        $qb = $this->em->createQueryBuilder();

        return $qb->select('mouvement', 'detail')
            ->from(MouvementStock::class, 'mouvement')
<<<<<<< Updated upstream
            ->leftJoin('mouvement.detailsMouvementStock', 'detail')
            ->where('detail.produit = :produit')
            ->setParameter('produit', $produit)
            ->orderBy('mouvement.dateHeure', 'ASC')  
=======
            ->leftJoin('mouvement.details', 'detail') // Vérifiez le bon nom de la relation
            ->where('detail.produit = :produit') // Modification ici pour utiliser detail
            ->setParameter('produit', $produit)
            ->orderBy('mouvement.dateHeure', 'ASC')
>>>>>>> Stashed changes
            ->getQuery()
            ->getResult();
    }

<<<<<<< Updated upstream


    /**
     * Calcule la valeur du stock selon la méthode FIFO (First In, First Out).
     *
     * @param MouvementStock[] $mouvements
     * @return float
     */
=======
>>>>>>> Stashed changes
    private function calculerValeurStockFIFO(array $mouvements): float
    {
        $valeurTotaleEntrees = 0.0; // Valeur totale des entrées
        $quantiteSortie = 0; // Quantité totale des sorties
        $stockRestant = []; // Tableau pour garder les quantités et les prix unitaires des entrées

        foreach ($mouvements as $mouvement) {
<<<<<<< Updated upstream
            $detailsMouvements = $mouvement->getDetailsMouvementStock();

            foreach ($detailsMouvements as $detail) {
                $typeMouvement = $mouvement->getTypeMouvementStock();
                
                if ($typeMouvement === TypeMouvementStock::ENTREE) {
                    $valeurTotale += $detail->getQuantite() * $detail->getPrixUnitaire();
                } elseif ($typeMouvement === TypeMouvementStock::SORTIE) {
                    $valeurTotale -= $detail->getQuantite() * $detail->getPrixUnitaire();
=======
            $detailsMouvements = $mouvement->getDetails(); // Récupérer les détails des mouvements

            foreach ($detailsMouvements as $detail) {
                $typeMouvement = $mouvement->getTypeMouvementStock(); // Type de mouvement (ENTRÉE ou SORTIE)
                $produit = $detail->getProduit(); // Récupérer le produit associé au mouvement

                // Si c'est une entrée, on l'ajoute au tableau des stocks restants
                if ($typeMouvement === TypeMouvementStock::ENTRE) {
                    $stockRestant[] = [
                        'quantite' => $detail->getQuantite(),
                        'prixUnitaire' => $produit->getPrixUnitaire()
                    ];
                } elseif ($typeMouvement === TypeMouvementStock::SORTIE) {
                    // Accumuler la quantité totale des sorties
                    $quantiteSortie += $detail->getQuantite();
>>>>>>> Stashed changes
                }
            }
        }

        // Calculer la valeur totale des sorties
        $valeurTotaleSorties = 0.0;
        $index = 0; // Index pour parcourir les entrées

        while ($quantiteSortie > 0 && $index < count($stockRestant)) {
            $premiereEntree = $stockRestant[$index];

            // Si la quantité de la première entrée est suffisante pour couvrir la sortie
            if ($premiereEntree['quantite'] <= $quantiteSortie) {
                $valeurTotaleSorties += $premiereEntree['quantite'] * $premiereEntree['prixUnitaire'];
                $quantiteSortie -= $premiereEntree['quantite']; // Réduire la quantité de sortie
                $index++; // Passer à l'entrée suivante
            } else {
                // S'il reste encore des sorties à traiter
                $valeurTotaleSorties += $quantiteSortie * $premiereEntree['prixUnitaire'];
                // Réduire la quantité de la première entrée
                $stockRestant[$index]['quantite'] -= $quantiteSortie;
                $quantiteSortie = 0; // Aucune sortie restante
            }
        }

        // La valeur totale du stock sera la valeur totale des entrées moins la valeur des sorties
        $valeurTotaleEntrees = 0.0;

        foreach ($stockRestant as $entree) {
            $valeurTotaleEntrees += $entree['quantite'] * $entree['prixUnitaire']; // Additionner les valeurs des entrées restantes
        }

        return $valeurTotaleEntrees - $valeurTotaleSorties; // Retourner la valeur totale du stock
    }




    /**
     * Calcule la valeur du stock selon la méthode LIFO (Last In, First Out).
     *
     * @param MouvementStock[] $mouvements
     * @return float
     */
    private function calculerValeurStockLIFO(array $mouvements): float
    {
        $valeurTotaleEntrees = 0.0; // Valeur totale des entrées
        $quantiteSortie = 0; // Quantité totale des sorties
        $stockRestant = []; // Tableau pour garder les quantités et les prix unitaires des entrées

        foreach ($mouvements as $mouvement) {
<<<<<<< Updated upstream
            // Récupérer les détails du mouvement
            $detailsMouvements = $mouvement->getDetailsMouvementStock();
=======
            $detailsMouvements = $mouvement->getDetails(); // Récupérer les détails des mouvements
>>>>>>> Stashed changes

            foreach ($detailsMouvements as $detail) {
                $typeMouvement = $mouvement->getTypeMouvementStock(); // Type de mouvement (ENTRÉE ou SORTIE)
                $produit = $detail->getProduit(); // Récupérer le produit associé au mouvement

<<<<<<< Updated upstream
                if ($typeMouvement === TypeMouvementStock::ENTREE) {
                    $valeurTotale += $detail->getQuantite() * $detail->getPrixUnitaire();
                } elseif ($typeMouvement === TypeMouvementStock::SORTIE) {
                    $valeurTotale -= $detail->getQuantite() * $detail->getPrixUnitaire();
=======
                // Si c'est une entrée, on l'ajoute au tableau des stocks restants
                if ($typeMouvement === TypeMouvementStock::ENTRE) {
                    $stockRestant[] = [
                        'quantite' => $detail->getQuantite(),
                        'prixUnitaire' => $produit->getPrixUnitaire()
                    ];
                } elseif ($typeMouvement === TypeMouvementStock::SORTIE) {
                    // Accumuler la quantité totale des sorties
                    $quantiteSortie += $detail->getQuantite();
>>>>>>> Stashed changes
                }
            }
        }

        // Calculer la valeur totale des sorties en utilisant LIFO
        $valeurTotaleSorties = 0.0;
        $index = count($stockRestant) - 1; // Démarrer à la fin du tableau des entrées

        while ($quantiteSortie > 0 && $index >= 0) {
            $derniereEntree = $stockRestant[$index];

            // Si la quantité de la dernière entrée est suffisante pour couvrir la sortie
            if ($derniereEntree['quantite'] <= $quantiteSortie) {
                $valeurTotaleSorties += $derniereEntree['quantite'] * $derniereEntree['prixUnitaire'];
                $quantiteSortie -= $derniereEntree['quantite']; // Réduire la quantité de sortie
                $index--; // Passer à l'entrée précédente
            } else {
                // S'il reste encore des sorties à traiter
                $valeurTotaleSorties += $quantiteSortie * $derniereEntree['prixUnitaire'];
                // Réduire la quantité de la dernière entrée
                $stockRestant[$index]['quantite'] -= $quantiteSortie;
                $quantiteSortie = 0; // Aucune sortie restante
            }
        }

        // La valeur totale du stock sera la valeur totale des entrées moins la valeur des sorties
        $valeurTotaleEntrees = 0.0;

        foreach ($stockRestant as $entree) {
            $valeurTotaleEntrees += $entree['quantite'] * $entree['prixUnitaire']; // Additionner les valeurs des entrées restantes
        }

        return $valeurTotaleEntrees - $valeurTotaleSorties; // Retourner la valeur totale du stock
    }


    
    /**
     * Calcule la valeur de stock en utilisant le Coût Normalisé Unitaire de Production (CNUP).
     *
     * @param MouvementStock[] $mouvements
     * @return float
     */
    private function calculerValeurStockCnup(array $mouvements): float
    {
        $totalEntrees = 0.0; 
        $quantiteDisponible = 0; 

        foreach ($mouvements as $mouvement) {
            // Récupérer les détails des mouvements de stock
            $detailsMouvements = $mouvement->getDetails();
            $typeMouvement = $mouvement->getTypeMouvementStock();

            foreach ($detailsMouvements as $detail) {
<<<<<<< Updated upstream
                if ($typeMouvement === TypeMouvementStock::ENTREE) {
                    $totalEntrees += $detail->getQuantite() * $detail->getPrixUnitaire();
                    $quantiteDisponible += $detail->getQuantite();
                } elseif ($typeMouvement === TypeMouvementStock::SORTIE) {
                    $quantiteDisponible -= $detail->getQuantite();
=======
                // Récupérer le produit associé pour obtenir le prix unitaire
                $produit = $detail->getProduit(); 

                if ($typeMouvement === TypeMouvementStock::ENTRE) {
                    // Ajouter la valeur totale de l'entrée et la quantité
                    $totalEntrees += $detail->getQuantite() * $produit->getPrixUnitaire();
                    $quantiteDisponible += $detail->getQuantite(); 
                } elseif ($typeMouvement === TypeMouvementStock::SORTIE) {
                    $quantiteDisponible -= $detail->getQuantite(); 
>>>>>>> Stashed changes
                }
            }
        }

        // Calculer le CNUP (Coût Normalisé Unitaire de Production)
        $cnup = $quantiteDisponible > 0 ? $totalEntrees / $quantiteDisponible : 0;

        // Valeur de stock totale à la fin
        return $quantiteDisponible * $cnup;
    }
}