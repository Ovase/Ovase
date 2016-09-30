<?php

namespace AppBundle\Entity\Repository;

use AppBundle\Entity\Project;
use Doctrine\ORM\EntityRepository;

class ProjectRepository extends EntityRepository
{
    public function findBySearch($searchTerm) // Beta version of function
    {
        return $this->createQueryBuilder('Project')
            ->select('Project')
            ->where('Project.name LIKE :searchTerm')
//            ->orWhere('Project.location LIKE :searchTerm')
//            ->orWhere('Project.technicalSolutions LIKE :searchTerm')
            ->setParameter('searchTerm', '%'.$searchTerm.'%')
            ->getQuery()
            ->getResult();
    }

    public function create($project)
    {
        $em = $this->getEntityManager();
        $em->persist($project);
        $em->flush();
        return $project;
    }
}