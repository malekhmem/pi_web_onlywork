<?php

namespace App\Repository;

use App\Entity\Annoncef;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Twilio\Rest\Client;
/**
 * @extends ServiceEntityRepository<Annoncef>
 *
 * @method Annoncef|null find($id, $lockMode = null, $lockVersion = null)
 * @method Annoncef|null findOneBy(array $criteria, array $orderBy = null)
 * @method Annoncef[]    findAll()
 * @method Annoncef[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnnoncefRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Annoncef::class);
    }

    public function save(Annoncef $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public  function sms(){
        // Your Account SID and Auth Token from twilio.com/console
                $sid = 'ACfa4edb6c41c3fb61158fb62d97b9dd61';
                $auth_token = 'fb4ec68748aa1bfc0641bba480372552';
        // In production, these should be environment variables. E.g.:
        // $auth_token = $_ENV["TWILIO_AUTH_TOKEN"]
        // A Twilio number you own with SMS capabilities
                $twilio_number = "+16318697050";
        
                $client = new Client($sid, $auth_token);
                $client->messages->create(
                // the number you'd like to send the message to
                    '+21692997134',
                    [
                        // A Twilio phone number you purchased at twilio.com/console
                        'from' => '+16318697050',
                        // the body of the text message you'd like to send
                        'body' => 'Une nouvelle annonce a été ajouter merci de consulter la liste des annonces pour plus de detail!'
                    ]
                );
            }

    public function remove(Annoncef $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Annoncef[] Returns an array of Annoncef objects
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

//    public function findOneBySomeField($value): ?Annoncef
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
public function SortByNomf(){
    return $this->createQueryBuilder('e')
        ->orderBy('e.nomf','ASC')
        ->getQuery()
        ->getResult()
        ;
}

public function SortByAdresse()
{
    return $this->createQueryBuilder('e')
        ->orderBy('e.adresse','ASC')
        ->getQuery()
        ->getResult()
        ;
}


public function SortByEmail()
{
    return $this->createQueryBuilder('e')
        ->orderBy('e.emailf','ASC')
        ->getQuery()
        ->getResult()
        ;
}








public function findBynomf( $nomf)
{
    return $this-> createQueryBuilder('e')
        ->andWhere('e.nomf LIKE :nomf')
        ->setParameter('nomf','%' .$nomf. '%')
        ->getQuery()
        ->execute();
}
public function findByadresse( $adresse)
{
    return $this-> createQueryBuilder('e')
        ->andWhere('e.adresse LIKE :adresse')
        ->setParameter('adresse','%' .$adresse. '%')
        ->getQuery()
        ->execute();
}
public function findByemail( $emailf)
{
    return $this-> createQueryBuilder('e')
        ->andWhere('e.emailf LIKE :emailf')
        ->setParameter('emailf','%' .$emailf. '%')
        ->getQuery()
        ->execute();
}


}
