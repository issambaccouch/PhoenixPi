<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Categorieprod
 *
 * @ORM\Table(name="categorieprod")
 * @ORM\Entity
 */
class Categorieprod
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idcp", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idcp;

    /**
     * @var string
     *
     * @ORM\Column(name="nomcp", type="string", length=255, nullable=true)
     */
    private $nomcp;



    /**
     * Get idcp
     *
     * @return integer
     */
    public function getIdcp()
    {
        return $this->idcp;
    }

    /**
     * Set nomcp
     *
     * @param string $nomcp
     *
     * @return Categorieprod
     */
    public function setNomcp($nomcp)
    {
        $this->nomcp = $nomcp;

        return $this;
    }

    /**
     * Get nomcp
     *
     * @return string
     */
    public function getNomcp()
    {
        return $this->nomcp;
    }
}
