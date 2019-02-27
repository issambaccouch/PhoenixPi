<?php

namespace TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Favoris
 *
 * @ORM\Table(name="favoris", indexes={@ORM\Index(name="iduser", columns={"iduser"}), @ORM\Index(name="idcp", columns={"idcp"})})
 * @ORM\Entity
 *  @ORM\Entity(repositoryClass="TestBundle\Repository\FavorisRepository")
 */
class Favoris
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idfav", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idfav;

    /**
     * @var \FosUser
     *
     * @ORM\ManyToOne(targetEntity="FosUser")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="iduser", referencedColumnName="id")
     * })
     */
    private $iduser;

    /**
     * @var \Categorieprod
     *
     * @ORM\ManyToOne(targetEntity="Categorieprod")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idcp", referencedColumnName="idcp")
     * })
     */
    private $idcp;



    /**
     * Get idfav
     *
     * @return integer
     */
    public function getIdfav()
    {
        return $this->idfav;
    }

    /**
     * Set iduser
     *
     * @param \TestBundle\Entity\FosUser $iduser
     *
     * @return Favoris
     */
    public function setIduser(\TestBundle\Entity\FosUser $iduser = null)
    {
        $this->iduser = $iduser;

        return $this;
    }

    /**
     * Get iduser
     *
     * @return \TestBundle\Entity\FosUser
     */
    public function getIduser()
    {
        return $this->iduser;
    }

    /**
     * Set idcp
     *
     * @param \TestBundle\Entity\Categorieprod $idcp
     *
     * @return Favoris
     */
    public function setIdcp(\TestBundle\Entity\Categorieprod $idcp = null)
    {
        $this->idcp = $idcp;

        return $this;
    }

    /**
     * Get idcp
     *
     * @return \TestBundle\Entity\Categorieprod
     */
    public function getIdcp()
    {
        return $this->idcp;
    }
}
