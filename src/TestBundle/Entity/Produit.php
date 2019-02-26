<?php

namespace TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Produit
 *
 * @ORM\Table(name="produit", indexes={@ORM\Index(name="iduser", columns={"iduser"}), @ORM\Index(name="idcp", columns={"idcp"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="TestBundle\Repository\ProduitRepository")
 */
class Produit
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idpr", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idpr;

    /**
     * @var string
     *
     * @ORM\Column(name="nomp", type="string", length=255, nullable=true)
     */
    private $nomp;

    /**
     * @var float
     *
     * @ORM\Column(name="prix", type="float", precision=10, scale=0, nullable=true)
     */
    private $prix;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="imagep", type="string", length=255, nullable=true)
     */
    private $imagep;

    /**
     * @var integer
     *
     * @ORM\Column(name="etatpr", type="integer", nullable=true)
     */
    private $etatpr;

    /**
     * @var integer
     *
     * @ORM\Column(name="enpromo", type="integer", nullable=true)
     */
    private $enpromo;

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
     * Get idpr
     *
     * @return integer
     */
    public function getIdpr()
    {
        return $this->idpr;
    }

    /**
     * Set nomp
     *
     * @param string $nomp
     *
     * @return Produit
     */
    public function setNomp($nomp)
    {
        $this->nomp = $nomp;

        return $this;
    }

    /**
     * Get nomp
     *
     * @return string
     */
    public function getNomp()
    {
        return $this->nomp;
    }

    /**
     * Set prix
     *
     * @param float $prix
     *
     * @return Produit
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get prix
     *
     * @return float
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Produit
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set imagep
     *
     * @param string $imagep
     *
     * @return Produit
     */
    public function setImagep($imagep)
    {
        $this->imagep = $imagep;

        return $this;
    }

    /**
     * Get imagep
     *
     * @return string
     */
    public function getImagep()
    {
        return $this->imagep;
    }

    /**
     * Set etatpr
     *
     * @param integer $etatpr
     *
     * @return Produit
     */
    public function setEtatpr($etatpr)
    {
        $this->etatpr = $etatpr;

        return $this;
    }

    /**
     * Get etatpr
     *
     * @return integer
     */
    public function getEtatpr()
    {
        return $this->etatpr;
    }

    /**
     * Set enpromo
     *
     * @param integer $enpromo
     *
     * @return Produit
     */
    public function setEnpromo($enpromo)
    {
        $this->enpromo = $enpromo;

        return $this;
    }

    /**
     * Get enpromo
     *
     * @return integer
     */
    public function getEnpromo()
    {
        return $this->enpromo;
    }

    /**
     * Set iduser
     *
     * @param \TestBundle\Entity\FosUser $iduser
     *
     * @return Produit
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
     * @return Produit
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
