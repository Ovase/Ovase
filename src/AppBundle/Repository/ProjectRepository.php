<?php

namespace AppBundle\Repository;

/**
 * ProjectRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProjectRepository extends \Doctrine\ORM\EntityRepository
{
    public function findProjects($searchterm)
    {
        return $this->createQueryBuilder('Project')
            ->select('Project')
            ->where('Project.name LIKE :searchterm')
            ->orWhere('Project.location LIKE :searchterm')
            ->setParameter('searchterm', '%'.$searchterm.'%')
            ->getQuery()
            ->getResult();
    }
}
