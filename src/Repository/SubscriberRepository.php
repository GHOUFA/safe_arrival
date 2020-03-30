<?php

namespace App\Repository;

use App\Entity\Subscriber;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\Expr;

/**
 * @method Subscriber|null find($id, $lockMode = null, $lockVersion = null)
 * @method Subscriber|null findOneBy(array $criteria, array $orderBy = null)
 * @method Subscriber[]    findAll()
 * @method Subscriber[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubscriberRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Subscriber::class);
    }

    // /**
    //  * @return Subscriber[] Returns an array of Subscriber objects
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
    public function findOneBySomeField($value): ?Subscriber
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    /**
     * @param $entity
     */
    public function save($entity){
        $this->_em->persist($entity);
        $this->_em->flush();
    }
    public function ajaxTablesubscriberlist(array $get, $flag = false){
        $alias = 'b';
        if (!isset($get['columns']) || empty($get['columns'])) {
            $get['columns'] = array('numero');
        }
        $aColumns = array();
        foreach ($get['columns'] as $value) {
            $aColumns[] = $alias . '.' . $value;
        }
        $qb = $this->createQueryBuilder($alias);

        /*
         * Ordering
         */
        if (isset($get['iSortCol_0'])) {
            for ($i = 0; $i < intval($get['iSortingCols']); $i++) {
                if ($get['bSortable_' . intval($get['iSortCol_' . $i])] == "true") {
                    $qb->orderBy($aColumns[(int)$get['iSortCol_' . $i]], $get['sSortDir_' . $i]);
                }
            }
        }
        /*
         * Filtering
         */
        if (isset($get['sSearch']) && $get['sSearch'] != '') {
            $aLike = array();
            for ($i = 0; $i < count($aColumns); $i++) {
                if (isset($get['bSearchable_' . $i]) && $get['bSearchable_' . $i] == "true") {
                    if ($aColumns[$i] == $alias . '.createdAt') {
                        $aLike[] = $qb->expr()->like("DATE_FORMAT(" . $alias . ".createdAt,  '%d-%m-%Y')", ':Search_date');
                        $qb->setParameter('Search_date', "%" . $get['sSearch'] . "%");
                    } else {
                        $aLike[] = $qb->expr()->like($aColumns[$i], ':Search');
                        $qb->setParameter('Search', "%" . $get['sSearch'] . "%");
                    }
                }
            }
            if (count($aLike) > 0) {
                $qb->andWhere(new Expr\Orx($aLike));
            } else {
                unset($aLike);
            }
        }
        for ($j = 0; $j < count($aColumns); $j++) {
            if ($j != 3) {
                if (isset($get['sSearch_' . $j]) && $get['sSearch_' . $j] != '') {
                    $aLike = array();
                    if ($aColumns[$j] == $alias . '.createdAt') {
                        $aLike[] = $qb->expr()->like("DATE_FORMAT(" . $alias . ".date,  '%d-%m-%Y')", ':Search_date');
                        $qb->setParameter('Search_date', "%" . $get['sSearch_' . $j] . "%");
                    } else {
                        $aLike[] = $qb->expr()->like($aColumns[$j], ':Search');
                        $qb->setParameter('Search', "%" . $get['sSearch_' . $j] . "%");
                    }
                    if (count($aLike) > 0) {
                        $qb->andWhere(new Expr\Orx($aLike));
                    } else {
                        unset($aLike);
                    }
                }
            }
        }
        if ($flag) {
            if (isset($get['iDisplayStart']) && $get['iDisplayLength'] != '-1') {
                $qb->setFirstResult((int)$get['iDisplayStart'])
                   ->setMaxResults((int)$get['iDisplayLength']);
            }
        } else {
            $qb->select('COUNT(' . $alias . ')');
        }
        $query = $qb->getQuery();

        return $query;
    }

    /**
     * @return int Total of Blacklist
     */
    public function getCountBlacklist()
    {
        $alias = 'b';
        $qb = $this->createQueryBuilder($alias);
        $qb->select('COUNT(' . $alias . ')');

        return $qb->getQuery()->getSingleScalarResult();
    }
}
