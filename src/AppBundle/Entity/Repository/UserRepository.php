<?php

namespace AppBundle\Entity\Repository;

use AppBundle\Entity\Semester;
use AppBundle\Entity\User;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

class UserRepository extends EntityRepository //implements UserProviderInterface // uncomment to define own provider
{

    public function findAllActiveUsers()
    {
        $users = $this->getEntityManager()->createQuery('
		
		SELECT u
		FROM AppBundle:User u
		WHERE u.isActive = :active
		')
        ->setParameter('active', 1)
        ->getResult();

        return $users;
    }

    public function findAllUsersByRoles($roles)
    {
        return $this->createQueryBuilder('u')
            ->select('u')
            ->join('u.roles', 'r')
            ->where('r.role IN (:roles)')
            ->setParameter('roles', $roles)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param $email
     *
     * @return User
     *
     * @throws NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findUserByEmail($email)
    {
        return $this->createQueryBuilder('User')
            ->select('User')
            ->where('User.email = :email')
            ->setParameter('email', $email)
            ->getQuery()
            ->getSingleResult();
    }

    /**
     * @param $id
     *
     * @return User
     *
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findUserByNewUserCode($id)
    {
        return $this->createQueryBuilder('User')
            ->select('User')
            ->where('User.new_user_code = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /*
    These functions are used by UserProviderInterface
    
    public function loadUserByUsername($email)
    {
        $q = $this
            ->createQueryBuilder('u')
            ->where('u.user_name = :user_name OR u.email = :email')
            ->setParameter('user_name', $email)
            ->setParameter('email', $email)
            ->getQuery();

        try {
            // The Query::getSingleResult() method throws an exception
            // if there is no record matching the criteria.
            $user = $q->getSingleResult();
        } catch (NoResultException $e) {
            $message = sprintf(
                'Unable to find an active admin VektorVektorBundle:User object identified by "%s".',
                $email
            );
            throw new UsernameNotFoundException($message, 0, $e);
        }

        return $user;
    }

    public function refreshUser(UserInterface $user)
    {
        $class = get_class($user);
        if (!$this->supportsClass($class)) {
            throw new UnsupportedUserException(
                sprintf(
                    'Instances of "%s" are not supported.',
                    $class
                )
            );
        }

        return $this->find($user->getId());
    } */

    public function supportsClass($class)
    {
        return $this->getEntityName() === $class
            || is_subclass_of($class, $this->getEntityName());
    }
}
