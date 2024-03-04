<?php

namespace App\Repository;

use App\Entity\COMMENTAIRE;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<COMMENTAIRE>
 *
 * @method COMMENTAIRE|null find($id, $lockMode = null, $lockVersion = null)
 * @method COMMENTAIRE|null findOneBy(array $criteria, array $orderBy = null)
 * @method COMMENTAIRE[]    findAll()
 * @method COMMENTAIRE[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class COMMENTAIRERepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, COMMENTAIRE::class);
    }

//    /**
//     * @return COMMENTAIRE[] Returns an array of COMMENTAIRE objects
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

//    public function findOneBySomeField($value): ?COMMENTAIRE
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
