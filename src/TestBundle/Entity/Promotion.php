<?php

namespace TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Promotion
 *
 * @ORM\Table(name="promotion", indexes={@ORM\Index(name="iduser", columns={"iduser"}), @ORM\Index(name="idpr", columns={"idpr"}), @ORM\Index(name="idcp", columns={"idcp"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="TestBundle\Repository\PromotionRepository")
 */
class Promotion
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idpromo", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idpromo;

    /**
     * @var float
     *
     * @ORM\Column(name="pourcentage", type="float", precision=10, scale=0, nullable=true)
     */
    private $pourcentage;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datefinpro", type="date", nullable=true)
     */
    private $datefinpro;

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
     * @var \Produit
     *
     * @ORM\ManyToOne(targetEntity="Produit")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idpr", referencedColumnName="idpr")
     * })
     */
    private $idpr;

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
     * Get idpromo
     *
     * @return integer
     */
    public function getIdpromo()
    {
        return $this->idpromo;
    }

    /**
     * Set pourcentage
     *
     * @param float $pourcentage
     *
     * @return Promotion
     */
    public function setPourcentage($pourcentage)
    {
        $this->pourcentage = $pourcentage;

        return $this;
    }

    /**
     * Get pourcentage
     *
     * @return float
     */
    public function getPourcentage()
    {
        return $this->pourcentage;
    }

    /**
     * Set datefinpro
     *
     * @param \DateTime $datefinpro
     *
     * @return Promotion
     */
    public function setDatefinpro($datefinpro)
    {
        $this->datefinpro = $datefinpro;

        return $this;
    }

    /**
     * Get datefinpro
     *
     * @return \DateTime
     */
    public function getDatefinpro()
    {
        return $this->datefinpro;
    }

    /**
     * Set iduser
     *
     * @param \TestBundle\Entity\FosUser $iduser
     *
     * @return Promotion
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
     * Set idpr
     *
     * @param \TestBundle\Entity\Produit $idpr
     *
     * @return Promotion
     */
    public function setIdpr(\TestBundle\Entity\Produit $idpr = null)
    {
        $this->idpr = $idpr;

        return $this;
    }

    /**
     * Get idpr
     *
     * @return \TestBundle\Entity\Produit
     */
    public function getIdpr()
    {
        return $this->idpr;
    }

    /**
     * Set idcp
     *
     * @param \TestBundle\Entity\Categorieprod $idcp
     *
     * @return Promotion
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
