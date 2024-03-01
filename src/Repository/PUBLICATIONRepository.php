<?php

namespace App\Repository;

use App\Entity\PUBLICATION;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PUBLICATION>
 *
 * @method PUBLICATION|null find($id, $lockMode = null, $lockVersion = null)
 * @method PUBLICATION|null findOneBy(array $criteria, array $orderBy = null)
 * @method PUBLICATION[]    findAll()
 * @method PUBLICATION[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PUBLICATIONRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PUBLICATION::class);
    }

//    /**
//     * @return PUBLICATION[] Returns an array of PUBLICATION objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?PUBLICATION
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
