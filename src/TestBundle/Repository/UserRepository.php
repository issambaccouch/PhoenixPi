<?php

namespace TestBundle\Repository;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends \Doctrine\ORM\EntityRepository
{
    public function modifieretat($date)
    {
        $query = $this->getEntityManager()->createQuery(" update TestBundle:Evenement e set e.etatev = -1 where e.idev=1 ");
        $query->execute();
    }

}
