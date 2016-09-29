<?php

namespace AppBundle\Entity\Repository;

use AppBundle\Entity\Project;
use Doctrine\ORM\EntityRepository;

class ProjectRepository extends EntityRepository
{
	/**
     * @param $searchTerm
     *
     * @return Projects
     */
    public function findBySearch($searchTerm) // Beta version of function
    {
    	return $this->createQueryBuilder('Project')
        ->select('Project')
        ->where('Project.location LIKE :searchTerm OR Project.name LIKE :searchTerm OR Project.technicalSolutions LIKE :searchTerm')
        ->setParameter('searchTerm', $searchTerm)
        ->getQuery()
        ->getResult();
    }
}