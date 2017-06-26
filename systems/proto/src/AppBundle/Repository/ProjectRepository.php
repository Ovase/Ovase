<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ProjectRepository extends EntityRepository
{
	public function findProjectsBySearch($searchTerm) // Beta version of function
	{
		return $this->createQueryBuilder('Project')
			->select('Project')
			->where('Project.name LIKE :searchTerm')
			->orWhere('Project.location LIKE :searchTerm')
            ->orWhere('Project.summary LIKE :searchTerm')
            ->orWhere('Project.description LIKE :searchTerm')
			->setParameter('searchTerm', '%'.$searchTerm.'%')
			->getQuery()
			->getResult();
	}
    public function findProjectsByArray($searchArr) // Description, demands and summary are text fields that could interchange
    {
        $freetxtsearch = array();
        foreach ($searchArr as $s) {
            $freetxtsearch = array_merge($freetxtsearch, $this->findProjectsBySearch($s));
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
