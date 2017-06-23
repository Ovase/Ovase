<?php

namespace AppBundle\Repository;
use Doctrine\ORM\EntityRepository;

class ImageRepository extends EntityRepository
{
    public function create($image)
    {
        $em = $this->getEntityManager();
        $em->persist($image);
        $em->flush();
        return $image;
    }
}
