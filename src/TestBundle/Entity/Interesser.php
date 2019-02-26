<?php

namespace TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Interesser
 *
 * @ORM\Table(name="interesser", indexes={@ORM\Index(name="idev", columns={"idev"}), @ORM\Index(name="iduser", columns={"iduser"})})
 * @ORM\Entity
 */
class Interesser
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idinter", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idinter;

    /**
     * @var \Evenement
     *
     * @ORM\ManyToOne(targetEntity="Evenement")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idev", referencedColumnName="idev")
     * })
     */
    private $idev;

    /**
     * @var \FosUser
     *
     * @ORM\ManyToOne(targetEntity="FosUser",cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="iduser", referencedColumnName="id")
     * })
     */
    private $iduser;



    /**
     * Get idinter
     *
     * @return integer
     */
    public function getIdinter()
    {
        return $this->idinter;
    }

    /**
     * Set idev
     *
     * @param \TestBundle\Entity\Evenement $idev
     *
     * @return Interesser
     */
    public function setIdev(\TestBundle\Entity\Evenement $idev = null)
    {
        $this->idev = $idev;

        return $this;
    }

    /**
     * Get idev
     *
     * @return \TestBundle\Entity\Evenement
     */
    public function getIdev()
    {
        return $this->idev;
    }

    /**
     * Set iduser
     *
     * @param \TestBundle\Entity\FosUser $iduser
     *
     * @return Interesser
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
}