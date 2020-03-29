<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\Expr;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
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
    public function ajaxTableuserlist(array $get, $flag = false){
        $alias = 'b';
        if (!isset($get['columns']) || empty($get['columns'])) {
            $get['columns'] = array('id');
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
                    if ($aColumns[$i] == $alias . '.date') {
                        $aLike[] = $qb->expr()->like("DATE_FORMAT(" . $alias . ".date,  '%d-%m-%Y')", ':Search_date');
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
                    if ($aColumns[$j] == $alias . '.date') {
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
