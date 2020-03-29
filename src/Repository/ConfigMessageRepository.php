<?php

namespace App\Repository;

use App\Entity\ConfigMessage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ConfigMessage|null find($id, $lockMode = null, $lockVersion = null)
 * @method ConfigMessage|null findOneBy(array $criteria, array $orderBy = null)
 * @method ConfigMessage[]    findAll()
 * @method ConfigMessage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConfigMessageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ConfigMessage::class);
    }

    // /**
    //  * @return ConfigMessage[] Returns an array of ConfigMessage objects
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
    public function findOneBySomeField($value): ?ConfigMessage
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
