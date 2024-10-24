<?php

namespace App\Repository\Achat;

use App\Entity\Achat\DemandeAchat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @extends ServiceEntityRepository<DemandeAchat>
 */
class DemandeAchatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DemandeAchat::class);
    }

    public function paginate(PaginatorInterface $paginator, $currentPage, $limit = 10): PaginationInterface
    {
        return $paginator->paginate(
            $this->createQueryBuilder("da")
                ->orderBy("da.dateHeure", "DESC")
                ->getQuery(),
            $currentPage, $limit
        );
    }

//    /**
//     * @return DemandeAchat[] Returns an array of DemandeAchat objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?DemandeAchat
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
