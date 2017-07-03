<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ProjectRepository extends EntityRepository
{
    public function findProjectsByTextSearch($searchTerm) {
        return $this->createQueryBuilder('Project')
            ->select('Project')
            ->where('Project.name LIKE :searchTerm')
            ->orWhere('Project.location LIKE :searchTerm')
            ->orWhere('Project.summary LIKE :searchTerm')
            ->orWhere('Project.description LIKE :searchTerm')
            ->orWhere('Project.leadText LIKE :searchTerm')
            ->setParameter('searchTerm', '%'.$searchTerm.'%')
            ->getQuery()
            ->getResult();
    }

    public function filterProjects($projects, $filters) {
        $remaining = $projects;
        if (array_key_exists('measureTypes', $filters))
            $remaining = self::filterOnMeasureTypes($remaining, $filters['measureTypes']);
        if (array_key_exists('measureFunctions', $filters))
            $remaining = self::filterOnMeasureFunctions($remaining, $filters['measureFunctions']);
        return $remaining;
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

    /* Keep project if any of its measures have a type among 
     * the selected measure types
     */
    private static function filterOnMeasureTypes($projects, $measureTypes) {
        if (is_null($measureTypes) || empty($measureTypes)) return $projects;
        $remaining = array_filter($projects, function($proj) use ($measureTypes) {
            foreach ($proj->getMeasures() as $measure) {
                if (in_array($measure->getType(), $measureTypes))
                    return true;
            }
            return false;
        });
        return $remaining;
    }

    /* Keep project if any of the selected functions exist
     * inside any of the projects meaures
     */
    private static function filterOnMeasureFunctions($projects, $filteredMeasureFunctions) {
        if (is_null($filteredMeasureFunctions) ||
            empty($filteredMeasureFunctions)) return $projects;
        $remaining = array_filter($projects, function($proj) use ($filteredMeasureFunctions) {
            foreach ($proj->getMeasures() as $measure) {
                $myFunctions = $measure->getFunctions();
                if (array_intersect($filteredMeasureFunctions, $myFunctions))
                    return true;
            }
            return false;
        });
        return $remaining;
    }
    
}
