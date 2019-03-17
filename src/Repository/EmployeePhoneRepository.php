<?php

namespace App\Repository;

use App\Entity\EmployeePhone;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method EmployeePhone|null find($id, $lockMode = null, $lockVersion = null)
 * @method EmployeePhone|null findOneBy(array $criteria, array $orderBy = null)
 * @method EmployeePhone[]    findAll()
 * @method EmployeePhone[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmployeePhoneRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, EmployeePhone::class);
    }

    // /**
    //  * @return EmployeePhone[] Returns an array of EmployeePhone objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?EmployeePhone
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
