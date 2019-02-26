<?php

namespace TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Categoriews
 *
 * @ORM\Table(name="categoriews")
 * @ORM\Entity(repositoryClass="TestBundle\Repository\CategorieWSRepository")
 */
class Categoriews
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idcw", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idcw;

    /**
     * @var string
     *
     * @ORM\Column(name="nomcws", type="string", length=255, nullable=true)
     */
    private $nomcws;

    public function __toString() {


        return (String)$this->idcw;
    }




    /**
     * Get idcw
     *
     * @return integer
     */
    public function getIdcw()
    {
        return $this->idcw;
    }

    /**
     * Set nomcws
     *
     * @param string $nomcws
     *
     * @return Categoriews
     */
    public function setNomcws($nomcws)
    {
        $this->nomcws = $nomcws;

        return $this;
    }

    /**
     * Get nomcws
     *
     * @return string
     */
    public function getNomcws()
    {
        return $this->nomcws;
    }
}
