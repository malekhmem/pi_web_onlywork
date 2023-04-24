<?php

namespace App\Repository;

use App\Entity\Poste;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Poste>
 *
 * @method Poste|null find($id, $lockMode = null, $lockVersion = null)
 * @method Poste|null findOneBy(array $criteria, array $orderBy = null)
 * @method Poste[]    findAll()
 * @method Poste[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PosteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Poste::class);
    }

    public function save(Poste $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Poste $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Poste[] Returns an array of Poste objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Poste
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
public function SortByNomp(){
    return $this->createQueryBuilder('e')
        ->orderBy('e.nomp','ASC')
        ->getQuery()
        ->getResult()
        ;
}

public function SortByDomaine()
{
    return $this->createQueryBuilder('e')
        ->orderBy('e.domaine','ASC')
        ->getQuery()
        ->getResult()
        ;
}


public function SortByEmail()
{
    return $this->createQueryBuilder('e')
        ->orderBy('e.emailp','ASC')
        ->getQuery()
        ->getResult()
        ;
}








public function findBynomp( $nomp)
{
    return $this-> createQueryBuilder('e')
        ->andWhere('e.nomp LIKE :nomp')
        ->setParameter('nomp','%' .$nomp. '%')
        ->getQuery()
        ->execute();
}
public function findByDomaine( $domaine)
{
    return $this-> createQueryBuilder('e')
        ->andWhere('e.domaine LIKE :domaine')
        ->setParameter('domaine','%' .$domaine. '%')
        ->getQuery()
        ->execute();
}
public function findByemail( $emailp)
{
    return $this-> createQueryBuilder('e')
        ->andWhere('e.emailp LIKE :emailp')
        ->setParameter('emailp','%' .$emailp. '%')
        ->getQuery()
        ->execute();
}
public function countByCategorie()
{
    return $this->createQueryBuilder('p')
        ->select('c.nomc as category, COUNT(p) as count')
        ->leftJoin('p.idcc', 'c')
        ->groupBy('c')
        ->getQuery()
        ->getResult();
}
}
