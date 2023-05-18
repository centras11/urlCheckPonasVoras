<?php

namespace App\Repository;

use App\Entity\Link;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Link>
 *
 * @method Link|null find($id, $lockMode = null, $lockVersion = null)
 * @method Link|null findOneBy(array $criteria, array $orderBy = null)
 * @method Link[]    findAll()
 * @method Link[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LinkRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Link::class);
    }

    public function save(Link $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findLinksByForm(?array $filter, int $userId): Query
    {
        $qb = $this->createQueryBuilder('l')
            ->andWhere('l.user = :userId')
            ->setParameter('userId',$userId);

        if ($filter) {
            if ($filter['title']) {
                $qb->andWhere('l.title LIKE :title')
                    ->setParameter('title', '%' . $filter['title'] . '%');
            }

            if ($filter['createdAtFrom']) {
                $qb->andWhere('l.createdAt >= :createdAtFrom')
                    ->setParameter('createdAtFrom', $filter['createdAtFrom']->setTime(0, 0, 0));
            }

            if ($filter['createdAtTo']) {
                $qb->andWhere('l.createdAt <= :createdAtTo')
                    ->setParameter('createdAtTo', $filter['createdAtTo']->setTime(23, 59, 59));
            }
        }

        return $qb->orderBy('l.id', Criteria::DESC)
            ->getQuery();
    }

    public function remove(Link $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
