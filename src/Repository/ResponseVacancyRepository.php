<?php

namespace App\Repository;

use App\Entity\ResponseVacancy;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ResponseVacancy|null find($id, $lockMode = null, $lockVersion = null)
 * @method ResponseVacancy|null findOneBy(array $criteria, array $orderBy = null)
 * @method ResponseVacancy[]    findAll()
 * @method ResponseVacancy[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResponseVacancyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ResponseVacancy::class);
    }

    // /**
    //  * @return ResponseVacancy[] Returns an array of ResponseVacancy objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ResponseVacancy
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
