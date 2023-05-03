<?php

namespace App\Repository;

use App\Entity\Materiel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Materiel>
 *
 * @method Materiel|null find($id, $lockMode = null, $lockVersion = null)
 * @method Materiel|null findOneBy(array $criteria, array $orderBy = null)
 * @method Materiel[]    findAll()
 * @method Materiel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MaterielRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Materiel::class);
    }

    public function save(Materiel $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Materiel $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Materiel[] Returns an array of Materiel objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Materiel
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }



public function SortByNomm(){
    return $this->createQueryBuilder('e')
        ->orderBy('e.nomm','ASC')
        ->getQuery()
        ->getResult()
        ;
}

public function SortByMarque()
{
    return $this->createQueryBuilder('e')
        ->orderBy('e.marque','ASC')
        ->getQuery()
        ->getResult()
        ;
}


public function SortByPrix()
{
    return $this->createQueryBuilder('e')
        ->orderBy('e.prix','ASC')
        ->getQuery()
        ->getResult()
        ;
}








public function findBynomm( $nomm)
{
    return $this-> createQueryBuilder('e')
        ->andWhere('e.nomm LIKE :nomm')
        ->setParameter('nomm','%' .$nomm. '%')
        ->getQuery()
        ->execute();
}
public function findBymarque( $marque)
{
    return $this-> createQueryBuilder('e')
        ->andWhere('e.marque LIKE :marque')
        ->setParameter('marque','%' .$marque. '%')
        ->getQuery()
        ->execute();
}
public function findByprix( $prix)
{
    return $this-> createQueryBuilder('e')
        ->andWhere('e.prix LIKE :prix')
        ->setParameter('prix','%' .$prix. '%')
        ->getQuery()
        ->execute();
}
}
