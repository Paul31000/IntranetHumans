<?php

namespace App\Repository;

use App\Entity\Champ;
use App\Entity\Questionnaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Champ|null find($id, $lockMode = null, $lockVersion = null)
 * @method Champ|null findOneBy(array $criteria, array $orderBy = null)
 * @method Champ[]    findAll()
 * @method Champ[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChampRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Champ::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Champ $entity): void
    {
        $this->_em->persist($entity);
        $this->_em->flush();
        $this->cutNumbers($entity->getQuestionnaire());
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Champ $entity): void
    {
        $questionnaireId=$entity->getQuestionnaire()->getId();
        $this->_em->remove($entity);
        
        $this->_em->flush();
        $repoQuestionnaire = $this->_em->getRepository(Questionnaire::class);
        $questionnaire = $repoQuestionnaire->findOneBy( array('id' => $questionnaireId));

        $this->cutNumbers($questionnaire);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function cutNumbers(Questionnaire $entity): void
    {
        $champs=$entity->getChampsOrdered();
        $j=0;
        foreach($champs as $champ){
            $j++;
            $champ->setOrdre($j);
            $this->_em->persist($entity);
        }

        $this->_em->flush();
    }

    // /**
    //  * @return Champ[] Returns an array of Champ objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Champ
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
