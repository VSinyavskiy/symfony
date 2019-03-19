<?php

namespace App\Repository;

use App\Entity\Employee;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use App\RequestPresenter\EmployeeWebRequestPresenter;

/**
 * @method Employee|null find($id, $lockMode = null, $lockVersion = null)
 * @method Employee|null findOneBy(array $criteria, array $orderBy = null)
 * @method Employee[]    findAll()
 * @method Employee[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmployeeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Employee::class);
    }

    /**
     * @return Employee[] Returns an array of Employee objects
     */
    public function findByFirstNameAndLastNameFields(EmployeeWebRequestPresenter $requestPresenter)
    {
        return $this->createQueryBuilder('e')
                        ->innerJoin('e.employeePhones', 'ep')
                        ->addSelect('ep')
                        ->andWhere('e.firstName LIKE :val')
                        ->orWhere('e.lastName LIKE :val')
                        ->setParameter('val', "%{$requestPresenter->getSearch()}%")
                        ->orderBy("e.{$requestPresenter->getOrderField()}", $requestPresenter->getOrderType())
                        ->getQuery()
                        ->execute();
    }
}
