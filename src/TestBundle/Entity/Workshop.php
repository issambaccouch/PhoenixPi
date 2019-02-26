<?php

namespace TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Workshop
 *
 * @ORM\Table(name="workshop", indexes={@ORM\Index(name="iduser", columns={"iduser"}), @ORM\Index(name="idcw", columns={"idcw"})})
 * @ORM\Entity
 * @ORM\Entity (repositoryClass="TestBundle\Repository\WorkshopRepository")
 *
 *
 */
class Workshop
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idws", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idws;

    /**
     * @var string
     *
     * @ORM\Column(name="nomws", type="string", length=255, nullable=true)
     */
    private $nomws;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datews", type="date", nullable=true)
     */
    private $datews;

    /**
     * @var string
     *
     * @ORM\Column(name="lieu", type="string", length=255, nullable=true)
     */
    private $lieu;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbrws", type="integer", nullable=true)
     */
    private $nbrws;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="etatws", type="integer", nullable=true)
     */
    private $etatws;

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
     * @var \Categoriews
     *
     * @ORM\ManyToOne(targetEntity="Categoriews")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idcw", referencedColumnName="idcw")
     * })
     */
    private $idcw;

    /**
     * Get idws
     *
     * @return int
     */
    public function getIdws()
    {
        return $this->idws;
    }


    /**
     * Set nomws
     *
     * @param string $nomws
     *
     * @return Workshop
     */
    public function setNomws($nomws)
    {
        $this->nomws = $nomws;

        return $this;
    }

    /**
     * Get nomws
     *
     * @return string
     */
    public function getNomws()
    {
        return $this->nomws;
    }


    /**
     * Set datews
     *
     * @param string $nomws
     *
     * @return Workshop
     */
    public function setDatews($datews)
    {
        $this->datews = $datews;

        return $this;
    }

    /**
     * Get datews
     *
     * @return datetime
     */
    public function getDatews()
    {
        return $this->datews;
    }


    /**
     * Set lieu
     *
     * @param string $nomws
     *
     * @return Workshop
     */
    public function setLieu($lieu)
    {
        $this->lieu = $lieu;

        return $this;
    }

    /**
     * Get lieu
     *
     * @return string
     */
    public function getLieu()
    {
        return $this->lieu;
    }


    /**
     * Set nbrws
     *
     * @param string $nomws
     *
     * @return Workshop
     */
    public function setNbrws($nbrws)
    {
        $this->nbrws = $nbrws;

        return $this;
    }

    /**
     * Get nbrws
     *
     * @return string
     */
    public function getNbrws()
    {
        return $this->nbrws;
    }


    /**
     * Set nomws
     *
     * @param string $nomws
     *
     * @return Workshop
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
     * Set etatws
     *
     * @param string $nomws
     *
     * @return Workshop
     */
    public function setEtatws($etatws)
    {
        $this->etatws = $etatws;

        return $this;
    }

    /**
     * Get lib
     *
     * @return string
     */
    public function getEtatws()
    {
        return $this->etatws;
    }


    /**
     * Set iduser
     *
     * @param integer $iduser
     *
     * @return Workshop
     */
    public function setIduser($iduser)
    {
        $this->iduser = $iduser;

        return $this;
    }

    /**
     * Get iduser
     *
     * @return integer
     */
    public function getIduser()
    {
        return $this->iduser;
    }

    /**
     * Set idcw
     *
     * @param integer $idcw
     *
     * @return Workshop
     */
    public function setIdcw($idcw)
    {
        $this->idcw = $idcw;

        return $this;
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

}

