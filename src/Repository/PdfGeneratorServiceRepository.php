<?php

namespace App\Repository;

use App\Entity\PdfGeneratorService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PdfGeneratorService>
 *
 * @method PdfGeneratorService|null find($id, $lockMode = null, $lockVersion = null)
 * @method PdfGeneratorService|null findOneBy(array $criteria, array $orderBy = null)
 * @method PdfGeneratorService[]    findAll()
 * @method PdfGeneratorService[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PdfGeneratorServiceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PdfGeneratorService::class);
    }

//    /**
//     * @return PdfGeneratorService[] Returns an array of PdfGeneratorService objects
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

//    public function findOneBySomeField($value): ?PdfGeneratorService
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
