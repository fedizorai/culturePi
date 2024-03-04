<?php

namespace App\Repository;

use App\Entity\Evenement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Evenement>
 *
 * @method Evenement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Evenement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Evenement[]    findAll()
 * @method Evenement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EvenementRepository extends ServiceEntityRepository
{
    
    
   
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Evenement::class);
    }
    public function SortByNomEvenement()
    {
        return $this->createQueryBuilder('e')
            ->orderBy('e.nomEvent', 'ASC')
            ->getQuery()
            ->getResult();
    }

    

    
public function SortBylieuEvenement()
{
    return $this->createQueryBuilder('e')
        ->orderBy('e.lieuEvent','ASC')
        ->getQuery()
        ->getResult()
        ;
}

public function SortByDateEvenement()
{
    return $this->createQueryBuilder('e')
        ->orderBy('e.dateEvent','ASC')
        ->getQuery()
        ->getResult()
        ;
}



    public function findByNomEvenement($nomEvenement)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.nomEvent LIKE :nomEvent')
            ->setParameter('nomEvent', '%' . $nomEvenement . '%')
            ->getQuery()
            ->execute();
    }

    public function findBylieuEvenement( $lieuEvenement)
{
    return $this-> createQueryBuilder('e')
        ->andWhere('e.lieuEvent LIKE :lieuEvent')
        ->setParameter('lieuEvent','%' .$lieuEvenement. '%')
        ->getQuery()
        ->execute();
}

public function findByDateEvenement( $DateEvenement)
{
    return $this-> createQueryBuilder('e')
        ->andWhere('e.dateEvent LIKE :dateEvent')
        ->setParameter('dateEvent','%' .$DateEvenement. '%')
        ->getQuery()
        ->execute(); 
}





//    /**
//     * @return Evenement[] Returns an array of Evenement objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Evenement
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
