<?php

namespace AppBundle\Controller;

use AppBundle\Constant\ENUM;
use AppBundle\Entity\Department;
use AppBundle\Entity\Employee;
use AppBundle\Entity\Persona;
use AppBundle\Entity\User;
use Doctrine\DBAL\DBALException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;

class HomeController extends Controller
{
  
    public function showHomeAction()
    {
        return $this->render('home/index.html.twig');
    }
}
