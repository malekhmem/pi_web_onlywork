<?php

namespace App\Repository;

use App\Entity\Annonces;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Annonces>
 *
 * @method Annonces|null find($id, $lockMode = null, $lockVersion = null)
 * @method Annonces|null findOneBy(array $criteria, array $orderBy = null)
 * @method Annonces[]    findAll()
 * @method Annonces[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnnoncesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Annonces::class);
    }

    public function save(Annonces $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Annonces $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Annonces[] Returns an array of Annonces objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Annonces
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
public function SortByNoms(){
    return $this->createQueryBuilder('e')
        ->orderBy('e.noms','ASC')
        ->getQuery()
        ->getResult()
        ;
}

public function SortByAdresse()
{
    return $this->createQueryBuilder('e')
        ->orderBy('e.adresses','ASC')
        ->getQuery()
        ->getResult()
        ;
}


public function SortByEmail()
{
    return $this->createQueryBuilder('e')
        ->orderBy('e.emails','ASC')
        ->getQuery()
        ->getResult()
        ;
}








public function findBynoms( $noms)
{
    return $this-> createQueryBuilder('e')
        ->andWhere('e.noms LIKE :noms')
        ->setParameter('noms','%' .$noms. '%')
        ->getQuery()
        ->execute();
}
public function findByadresse( $adresses)
{
    return $this-> createQueryBuilder('e')
        ->andWhere('e.adresses LIKE :adresses')
        ->setParameter('adresses','%' .$adresses. '%')
        ->getQuery()
        ->execute();
}
public function findByemail( $emails)
{
    return $this-> createQueryBuilder('e')
        ->andWhere('e.emails LIKE :emails')
        ->setParameter('emails','%' .$emails. '%')
        ->getQuery()
        ->execute();
}

}
