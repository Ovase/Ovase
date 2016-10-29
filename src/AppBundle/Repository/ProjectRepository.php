<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Project;
use Doctrine\ORM\EntityRepository;

class ProjectRepository extends EntityRepository
{
	public function findProjectsByLocation($searchTerm) // Beta version of function
	{
		return $this->createQueryBuilder('Project')
			->select('Project')
			->where('Project.name LIKE :searchTerm')
			->orwhere('Project.location LIKE :searchTerm')
			->setParameter('searchTerm', '%'.strtolower($searchTerm).'%')
			->getQuery()
			->getResult();
	}
    public function findProjectsByArray($search) // Description, demands and summary are text fields that could interchange
    {
        $freetxtsearch = array();
        foreach ($search as $s) {
            $freetxtsearch = array_merge($freetxtsearch, $this->createQueryBuilder('Project')
                ->select('Project')
                ->where('Project.dimentional_demands LIKE :searchTerm')
                ->setParameter('searchTerm', '%'.$s.'%')
                ->getQuery()
                ->getResult()); // returns an array, ja?
            $freetxtsearch = array_merge($freetxtsearch, $this->createQueryBuilder('Project')
                ->select('Project')
                ->where('Project.summary LIKE :searchTerm')
                ->setParameter('searchTerm', '%'.$s.'%')
                ->getQuery()
                ->getResult()); // returns an array, ja?
            $freetxtsearch = array_merge($freetxtsearch, $this->createQueryBuilder('Project')
                ->select('Project')
                ->where('Project.description LIKE :searchTerm')
                ->setParameter('searchTerm', '%'.$s.'%')
                ->getQuery()
                ->getResult()); // returns an array, ja?
            $freetxtsearch = array_merge($freetxtsearch, $this->createQueryBuilder('Project')
                ->select('Project')
                ->where('Project.technical_solutions LIKE :searchTerm')
                ->setParameter('searchTerm', '%'.$s.'%')
                ->getQuery()
                ->getResult()); // returns an array, ja?
        }
        $freetxtsearch = array_unique($freetxtsearch);
        return $freetxtsearch;
    }

	// Used for testing purposes
	public function findProjectsByName($name)
	{
		return $this->createQueryBuilder('Project')
			->select('Project')
			->where('Project.name = :name')
			->setParameter('name', $name)
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

	public function findAllTestProjects()
	{
		return $this->createQueryBuilder('Project')
			->select('Project')
			->where('Project.field = :t')
			->setParameter('t', "TEST")
			->getQuery()
			->getResult();
	}

	public function findEditedProjects()
	{
		return $this->createQueryBuilder('Project')
			->select('Project')
			->where('Project.version > 0')
			->getQuery()
			->getResult();
	}
	
}
