<?php

namespace App\Repository;

use App\Entity\HEBERGEMENT;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<HEBERGEMENT>
 *
 * @method HEBERGEMENT|null find($id, $lockMode = null, $lockVersion = null)
 * @method HEBERGEMENT|null findOneBy(array $criteria, array $orderBy = null)
 * @method HEBERGEMENT[]    findAll()
 * @method HEBERGEMENT[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HEBERGEMENTRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HEBERGEMENT::class);
    }

//    /**
//     * @return HEBERGEMENT[] Returns an array of HEBERGEMENT objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('h.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?HEBERGEMENT
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
