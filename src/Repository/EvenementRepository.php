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

    public function save(Evenement $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Evenement $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
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
public function SortByNomss(){
    return $this->createQueryBuilder('e')
        ->orderBy('e.nomss','ASC')
        ->getQuery()
        ->getResult()
        ;
}

public function SortByTitre()
{
    return $this->createQueryBuilder('e')
        ->orderBy('e.titre','ASC')
        ->getQuery()
        ->getResult()
        ;
}


public function SortByDescription()
{
    return $this->createQueryBuilder('e')
        ->orderBy('e.description','ASC')
        ->getQuery()
        ->getResult()
        ;
}








public function findBynomss( $nomss)
{
    return $this-> createQueryBuilder('e')
        ->andWhere('e.nomss LIKE :nomss')
        ->setParameter('nomss','%' .$nomss. '%')
        ->getQuery()
        ->execute();
}
public function findBytitre( $titre)
{
    return $this-> createQueryBuilder('e')
        ->andWhere('e.titre LIKE :titre')
        ->setParameter('titre','%' .$titre. '%')
        ->getQuery()
        ->execute();
}
public function findBydescription( $description)
{
    return $this-> createQueryBuilder('e')
        ->andWhere('e.description LIKE :description')
        ->setParameter('description','%' .$description. '%')
        ->getQuery()
        ->execute();
}

}
