<?php

namespace App\Repository;

use App\Entity\CategorieEvent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CategorieEvent>
 *
 * @method CategorieEvent|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategorieEvent|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategorieEvent[]    findAll()
 * @method CategorieEvent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategorieEventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategorieEvent::class);
    }

//    /**
//     * @return CategorieEvent[] Returns an array of CategorieEvent objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CategorieEvent
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
