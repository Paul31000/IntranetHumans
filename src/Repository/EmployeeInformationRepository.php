<?php

namespace App\Repository;

use App\Entity\EmployeeInformation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EmployeeInformation|null find($id, $lockMode = null, $lockVersion = null)
 * @method EmployeeInformation|null findOneBy(array $criteria, array $orderBy = null)
 * @method EmployeeInformation[]    findAll()
 * @method EmployeeInformation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmployeeInformationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EmployeeInformation::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(EmployeeInformation $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(EmployeeInformation $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
    * @return birthdays[] Returns an array of birthdays objects
    */
    public function getbirthdays()
    {

        $conn = $this->getEntityManager()->getConnection();

        $sql = "
            SELECT * FROM employee_information EI
            WHERE DATE_FORMAT(EI.date_naissance, '%m-%d') >= DATE_FORMAT(NOW(), '%m-%d') 
            AND DATE_FORMAT(EI.date_naissance, '%m-%d') <= DATE_FORMAT((NOW() + INTERVAL +1 DAY), '%m-%d')
            ";
            

        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();

        return $resultSet->fetchAllAssociative();
    }

    // /**
    //  * @return EmployeeInformation[] Returns an array of EmployeeInformation objects
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
    public function findOneBySomeField($value): ?EmployeeInformation
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
