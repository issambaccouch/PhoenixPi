<?php

namespace TestBundle\Repository;

/**
 * EvenementRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProduitRepository extends \Doctrine\ORM\EntityRepository
{
    public function produitEnPromo($id,$pourcentage)
    {
        $query = $this->getEntityManager()->createQuery("update TestBundle:Produit p set p.enpromo =p.prix-(p.prix*('$pourcentage'/100)) where p.idpr='$id'");
        $query->execute();
    }


    public function produitNonPromo($id)
    {
        $query = $this->getEntityManager()->createQuery("update TestBundle:Produit p set p.enpromo =NULL where p.idpr='$id'");
        $query->execute();
    }
}