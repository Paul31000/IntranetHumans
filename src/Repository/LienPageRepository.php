<?php

namespace App\Repository;

use App\Entity\Categorie;
use App\Entity\LienPage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Path;

/**
 * @method LienPage|null find($id, $lockMode = null, $lockVersion = null)
 * @method LienPage|null findOneBy(array $criteria, array $orderBy = null)
 * @method LienPage[]    findAll()
 * @method LienPage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LienPageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LienPage::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(LienPage $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }
    
    
    public function removeImage(LienPage $entity): void
    {
        $filesystem = new Filesystem();
        if($entity->getImage()!="/uploads/images/"){
            $filesystem->remove("../public".$entity->getImage());
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(LienPage $entity, bool $flush = true): void
    {
        $this->removeImage($entity);
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }


   
    /**
    * @return LienPage[] Returns an array of LienPage objects
    */

    public function findByPageAndCat( string $cat,string $page): array
    {
        $entityManager = $this->getEntityManager();

        $query =  $this->createQueryBuilder('l')
            ->Join('l.pages', 'p','WITH','p.nomUrl = :page')
            ->Join('l.categorie','c','WITH','c.nom = :cat')
            ->setParameters(array(
            'page' => $page,
            'cat' => $cat,
        ));
        return $query->getQuery()->getResult();
    }

    /**
     * @return LienPage[] Returns an array of LienPage objects
     */

    public function findLienByName( string $nom ): array
    {
        $entityManager = $this->getEntityManager();

        $query =  $this->createQueryBuilder('l');
            $query
                ->where(
                    $query->expr()->andX(
                        $query->expr()->orX(
                            $query->expr()->like('l.description', ':nom')
                    ),
                        $query->expr()->isNotNull('l.description')
                    )
                )
                ->orWhere(
                    $query->expr()->andX(
                        $query->expr()->orX(
                            $query->expr()->like('l.apropos', ':nom')
                    ),
                        $query->expr()->isNotNull('l.description')
                    )
                )
                ->setParameter('nom', '%' . $nom. '%')
            ;

        return $query->getQuery()->getResult();
    }
}

