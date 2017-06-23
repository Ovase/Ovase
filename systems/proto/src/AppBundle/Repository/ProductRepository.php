<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ProductRepository extends EntityRepository
{
    public function create($product)
    {
        $em = $this->getEntityManager();
        $em->persist($product);
        $em->flush();
        return $product;
    }
}
