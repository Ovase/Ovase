<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Project;
use Doctrine\ORM\EntityRepository;

class ProjectRepository extends EntityRepository
{
	public function findProjectsBySearch($searchTerm) // Beta version of function
	{
		return $this->createQueryBuilder('Project')
			->select('Project')
			->where('Project.name LIKE :searchTerm')
			->orwhere('Project.location LIKE :searchTerm')
//			->orWhere('Project.technicalSolutions LIKE :searchTerm')
			->setParameter('searchTerm', '%'.strtolower($searchTerm).'%')
			->getQuery()
			->getResult();
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

}
