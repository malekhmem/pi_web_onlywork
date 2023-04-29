<?php

namespace App\Repository;

use App\Entity\Blacklist;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Blackliste>
 *
 * @method Blacklist|null find($id, $lockMode = null, $lockVersion = null)
 * @method Blacklist|null findOneBy(array $criteria, array $orderBy = null)
 * @method Blacklist[]    findAll()
 * @method Blacklist[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BlacklisteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Blacklist::class);
    }

    public function save(Blacklist $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Blacklist $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Blacklist[] Returns an array of Blacklist objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Blacklist
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
public function SortBydescb()
{
    return $this->createQueryBuilder('e')
        ->orderBy('e.descb','ASC')
        ->getQuery()
        ->getResult()
        ;
}

public function findBydescb( $descb)
{
    return $this-> createQueryBuilder('e')
        ->andWhere('e.descb LIKE :descb')
        ->setParameter('descb','%' .$descb. '%')
        ->getQuery()
        ->execute();
}
}
