<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Evenement
 *
 * @ORM\Table(name="evenement", indexes={@ORM\Index(name="iduser", columns={"iduser"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\EvenementRepository")
 */
class Evenement
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idev", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idev;

    /**
     * @var string
     *
     * @ORM\Column(name="nomev", type="string", length=255, nullable=true)
     */
    private $nomev;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datedebut", type="date", nullable=true)
     */
    private $datedebut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datefin", type="date", nullable=true)
     */
    private $datefin;

    /**
     * @var integer
     *
     * @ORM\Column(name="etatev", type="integer", nullable=true)
     */
    private $etatev;

    /**
     * @var string
     *
     * @ORM\Column(name="imageev", type="string", length=255, nullable=true)
     */
    private $imageev;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbrparticipants", type="integer", nullable=true)
     */
    private $nbrparticipants;

    /**
     * @var string
     *
     * @ORM\Column(name="lieu", type="string", length=255, nullable=false)
     */
    private $lieu;

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
     * Get idev
     *
     * @return integer
     */
    public function getIdev()
    {
        return $this->idev;
    }

    /**
     * Set nomev
     *
     * @param string $nomev
     *
     * @return Evenement
     */
    public function setNomev($nomev)
    {
        $this->nomev = $nomev;

        return $this;
    }

    /**
     * Get nomev
     *
     * @return string
     */
    public function getNomev()
    {
        return $this->nomev;
    }

    /**
     * Set datedebut
     *
     * @param \DateTime $datedebut
     *
     * @return Evenement
     */
    public function setDatedebut($datedebut)
    {
        $this->datedebut = $datedebut;

        return $this;
    }

    /**
     * Get datedebut
     *
     * @return \DateTime
     */
    public function getDatedebut()
    {
        return $this->datedebut;
    }

    /**
     * Set datefin
     *
     * @param \DateTime $datefin
     *
     * @return Evenement
     */
    public function setDatefin($datefin)
    {
        $this->datefin = $datefin;

        return $this;
    }

    /**
     * Get datefin
     *
     * @return \DateTime
     */
    public function getDatefin()
    {
        return $this->datefin;
    }

    /**
     * Set etatev
     *
     * @param integer $etatev
     *
     * @return Evenement
     */
    public function setEtatev($etatev)
    {
        $this->etatev = $etatev;

        return $this;
    }

    /**
     * Get etatev
     *
     * @return integer
     */
    public function getEtatev()
    {
        return $this->etatev;
    }

    /**
     * Set imageev
     *
     * @param string $imageev
     *
     * @return Evenement
     */
    public function setImageev($imageev)
    {
        $this->imageev = $imageev;

        return $this;
    }

    /**
     * Get imageev
     *
     * @return string
     */
    public function getImageev()
    {
        return $this->imageev;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Evenement
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
     * Set nbrparticipants
     *
     * @param integer $nbrparticipants
     *
     * @return Evenement
     */
    public function setNbrparticipants($nbrparticipants)
    {
        $this->nbrparticipants = $nbrparticipants;

        return $this;
    }

    /**
     * Get nbrparticipants
     *
     * @return integer
     */
    public function getNbrparticipants()
    {
        return $this->nbrparticipants;
    }

    /**
     * Set lieu
     *
     * @param string $lieu
     *
     * @return Evenement
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
     * Set iduser
     *
     * @param \AdminBundle\Entity\FosUser $iduser
     *
     * @return Evenement
     */
    public function setIduser(\AdminBundle\Entity\FosUser $iduser = null)
    {
        $this->iduser = $iduser;

        return $this;
    }

    /**
     * Get iduser
     *
     * @return \AdminBundle\Entity\FosUser
     */
    public function getIduser()
    {
        return $this->iduser;
    }
}
