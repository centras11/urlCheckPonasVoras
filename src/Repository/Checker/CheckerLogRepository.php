<?php

namespace App\Repository\Checker;

use App\Entity\Checker\CheckerLog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CheckerLog>
 *
 * @method CheckerLog|null find($id, $lockMode = null, $lockVersion = null)
 * @method CheckerLog|null findOneBy(array $criteria, array $orderBy = null)
 * @method CheckerLog[]    findAll()
 * @method CheckerLog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CheckerLogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CheckerLog::class);
    }

    public function save(CheckerLog $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CheckerLog $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function findCheckerLogsByForm(?array $filter, int $userId): Query
    {
        $qb = $this->createQueryBuilder('cl')
            ->leftJoin('cl.link','cll')
            ->andWhere('cll.user = :userId')
            ->setParameter('userId',$userId);

        if ($filter) {
            if ($filter['action']) {
                $qb->andWhere('cl.action = :action')
                    ->setParameter('action', $filter['action']);
            }

            if ($filter['value']) {
                $qb->andWhere('cl.value = :value')
                    ->setParameter('value',  $filter['value']);
            }

            if ($filter['link']) {
                $qb->andWhere('cl.link = :link')
                    ->setParameter('link', $filter['link'] );
            }

            if ($filter['createdAtFrom']) {
                $qb->andWhere('cl.createdAt >= :createdAtFrom')
                    ->setParameter('createdAtFrom', $filter['createdAtFrom']->setTime(0, 0, 0));
            }

            if ($filter['createdAtTo']) {
                $qb->andWhere('cl.createdAt <= :createdAtTo')
                    ->setParameter('createdAtTo', $filter['createdAtTo']->setTime(23, 59, 59));
            }
        }

        return $qb->orderBy('cl.id', Criteria::DESC)
            ->getQuery();
    }
}
