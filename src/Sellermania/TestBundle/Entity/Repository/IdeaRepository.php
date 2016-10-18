<?php

namespace Sellermania\TestBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;


/**
 * IdeaRepository
 *
 */
class IdeaRepository extends EntityRepository
{
    public function findAllWithPopularity()
    {
        $qb = $this->createQueryBuilder("i")
            ->leftJoin('i.votes', 'v')
            ->addSelect('SUM(v.value) as HIDDEN popularity')
            ->groupBy('i.id')
            ->orderBy("popularity", "desc")
            ->addOrderBy('i.id', 'ASC');      

        return $qb->getQuery()->getResult();
    }

    public function getPopularityByIdea(Idea $idea){
        $qb = $this->createQueryBuilder("i")
            ->select('sum(v.value) as popularity')
            ->leftJoin("SellermaniaTestBundle:Vote", 'v', 'WITH', 'v.idea = i.id')
            ->where('i.id = :idea_id')
            ->setParameter('idea_id', $idea->getId());      

        return $qb->getQuery()->getSingleScalarResult();
    }
}