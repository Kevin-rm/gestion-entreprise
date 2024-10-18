<?php

namespace App\Repository\Stock;

use App\Entity\Stock\Inventaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Inventaire>
 */
class InventaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Inventaire::class);
    }

    
    public function getLastInventaireByProduit(int $idProduit): ?Inventaire
    {
        return $this->createQueryBuilder('i')
            ->innerJoin('i.detailsInventaire', 'd')
            ->andWhere('d.produit = :idProduit')
            ->setParameter('idProduit', $idProduit)
            ->orderBy('i.dateHeur', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function updateStockWithMouvement(Inventaire $inventaire, array $mouvementsStock, string $methodeStockage = 'FIFO'): Inventaire
    {
        foreach ($mouvementsStock as $mouvement) {
            if ($mouvement->getType() === 'entree') {
                $inventaire->setValeurTotale(
                    $inventaire->getValeurTotale() + $mouvement->getQuantite()
                );
            } elseif ($mouvement->getType() === 'sortie') {
                $inventaire->setValeurTotale(
                    $inventaire->getValeurTotale() - $mouvement->getQuantite()
                );
            }
        }

        return $inventaire;
    }

    public function applyStockMethod(Inventaire $inventaire, array $detailsMouvementStock, string $methodeStockage = 'FIFO'): Inventaire
    {
        if ($methodeStockage === 'FIFO') {
            usort($detailsMouvementStock, function($a, $b) {
                return $a->getDateHeure() <=> $b->getDateHeure();
            });
        } elseif ($methodeStockage === 'LIFO') {
            usort($detailsMouvementStock, function($a, $b) {
                return $b->getDateHeure() <=> $a->getDateHeure();
            });
        }

        return $this->updateStockWithMouvement($inventaire, $detailsMouvementStock, $methodeStockage);
    }




//    /**
//     * @return Inventaire[] Returns an array of Inventaire objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Inventaire
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
