<?php

namespace App\Repository;

use App\Entity\Reservhebergement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Reservhebergement>
 *
 * @method Reservhebergement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reservhebergement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reservhebergement[]    findAll()
 * @method Reservhebergement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReservhebergementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reservhebergement::class);
    }

//    /**
//     * @return Reservhebergement[] Returns an array of Reservhebergement objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Reservhebergement
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
