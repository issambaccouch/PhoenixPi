<?php

namespace TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reclamation
 *
 * @ORM\Table(name="reclamation", indexes={@ORM\Index(name="iduser", columns={"iduser"}), @ORM\Index(name="idart", columns={"idart"})})
 * @ORM\Entity
 */
class Reclamation
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idrec", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idrec;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="daterec", type="date", nullable=true)
     */
    private $daterec;



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
     * @var \Article
     *
     * @ORM\ManyToOne(targetEntity="Article")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idart", referencedColumnName="idart")
     * })
     */
    private $idart;



    /**
     * Get idrec
     *
     * @return integer
     */
    public function getIdrec()
    {
        return $this->idrec;
    }

    /**
     * Set daterec
     *
     * @param \DateTime $daterec
     *
     * @return Reclamation
     */
    public function setDaterec($daterec)
    {
        $this->daterec = $daterec;

        return $this;
    }

    /**
     * Get daterec
     *
     * @return \DateTime
     */
    public function getDaterec()
    {
        return $this->daterec;
    }

    /**
     * Set contenu
     *
     * @param string $contenu
     *
     * @return Reclamation
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * Get contenu
     *
     * @return string
     */
    public function getContenu()
    {
        return $this->contenu;
    }

    /**
     * Set iduser
     *
     * @param \TestBundle\Entity\FosUser $iduser
     *
     * @return Reclamation
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
     * Set idart
     *
     * @param \TestBundle\Entity\Article $idart
     *
     * @return Reclamation
     */
    public function setIdart(\TestBundle\Entity\Article $idart = null)
    {
        $this->idart = $idart;

        return $this;
    }

    /**
     * Get idart
     *
     * @return \TestBundle\Entity\Article
     */
    public function getIdart()
    {
        return $this->idart;
    }
}
