<?php

namespace App\Repository;

use App\Entity\Salle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Salle|null find($id, $lockMode = null, $lockVersion = null)
 * @method Salle|null findOneBy(array $criteria, array $orderBy = null)
 * @method Salle[]    findAll()
 * @method Salle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SalleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Salle::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Salle $entity, bool $flush = true): void
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
    public function remove(Salle $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /* public function estDispo(Salle $salle,int $heure)
    {

        $conn = $this->getEntityManager()->getConnection();

        $sql = "
            SELECT nom_occupant FROM occupation_salle os, salle s, salle_occupation_salle sos
            WHERE :SalleId= sos.salle_id
            AND sos.occupation_salle_id = os.id
            
            AND (DATE_FORMAT(os.creneau, '%m-%d-%H-%i') < DATE_FORMAT(FROM_UNIXTIME(:heureFin) , '%m-%d-%H-%i')
            AND DATE_FORMAT(FROM_UNIXTIME( :heureDebut), '%m-%d-%H-%i') < DATE_FORMAT(os.fin_creneau, '%m-%d-%H-%i'))
            
                ;
            ";

        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery([ 'SalleId' => $salle->getId() ,  'heureDebut' => $heure , 'heureFin' => strtotime('+ 1 hour',$heure) ]);
        return $resultSet->fetchAllAssociative();
       
    } */
    // /**
    //  * @return Salle[] Returns an array of Salle objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Salle
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
