<?php

namespace TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Article
 *
 * @ORM\Table(name="article", indexes={@ORM\Index(name="iduser", columns={"iduser"}), @ORM\Index(name="idtag", columns={"idtag"})})
 * @ORM\Entity
 */
class Article
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idart", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idart;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255, nullable=true)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="string", length=255, nullable=true)
     */
    private $text;

    /**
     * @var string
     *
     * @ORM\Column(name="imageart", type="string", length=255, nullable=true)
     */
    private $imageart;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbrvue", type="integer", nullable=true)
     */
    private $nbrvue;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateajout", type="date", nullable=true)
     */
    private $dateajout;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbrrec", type="integer", nullable=true)
     */
    private $nbrrec;

    /**
     * @var integer
     *
     * @ORM\Column(name="approve", type="integer", nullable=true)
     */
    private $approve;

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
     * @var \Tags
     *
     * @ORM\ManyToOne(targetEntity="Tags")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idtag", referencedColumnName="idtag")
     * })
     */
    private $idtag;





    /**
     * Get idart
     *
     * @return integer
     */
    public function getIdart()
    {
        return $this->idart;
    }

    /**
     * Set titre
     *
     * @param string $titre
     *
     * @return Article
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set text
     *
     * @param string $text
     *
     * @return Article
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set imageart
     *
     * @param string $imageart
     *
     * @return Article
     */
    public function setImageart($imageart)
    {
        $this->imageart = $imageart;

        return $this;
    }

    /**
     * Get imageart
     *
     * @return string
     */
    public function getImageart()
    {
        return $this->imageart;
    }

    /**
     * Set nbrvue
     *
     * @param integer $nbrvue
     *
     * @return Article
     */
    public function setNbrvue($nbrvue)
    {
        $this->nbrvue = $nbrvue;

        return $this;
    }

    /**
     * Get nbrvue
     *
     * @return integer
     */
    public function getNbrvue()
    {
        return $this->nbrvue;
    }

    /**
     * Set dateajout
     *
     * @param \DateTime $dateajout
     *
     * @return Article
     */
    public function setDateajout($dateajout)
    {
        $this->dateajout = $dateajout;

        return $this;
    }

    /**
     * Get dateajout
     *
     * @return \DateTime
     */
    public function getDateajout()
    {
        return $this->dateajout;
    }

    /**
     * Set nbrrec
     *
     * @param integer $nbrrec
     *
     * @return Article
     */
    public function setNbrrec($nbrrec)
    {
        $this->nbrrec = $nbrrec;

        return $this;
    }

    /**
     * Get nbrrec
     *
     * @return integer
     */
    public function getNbrrec()
    {
        return $this->nbrrec;
    }

    /**
     * Set approve
     *
     * @param integer $approve
     *
     * @return Article
     */
    public function setApprove($approve)
    {
        $this->approve = $approve;

        return $this;
    }

    /**
     * Get approve
     *
     * @return integer
     */
    public function getApprove()
    {
        return $this->approve;
    }

    /**
     * Set iduser
     *
     * @param \TestBundle\Entity\FosUser $iduser
     *
     * @return Article
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
     * Set idtag
     *
     * @param \TestBundle\Entity\Tags $idtag
     *
     * @return Article
     */
    public function setIdtag(\TestBundle\Entity\Tags $idtag = null)
    {
        $this->idtag = $idtag;

        return $this;
    }

    /**
     * Get idtag
     *
     * @return \TestBundle\Entity\Tags
     */
    public function getIdtag()
    {
        return $this->idtag;
    }

    /**
     * Add nbrvue
     * @return $Article
     */
public function addnbrvue()
{
    $this->nbrvue=$this->nbrvue+1;
    return $this;
}
    public function __toString() {


        return (String)$this->idart;
    }

}
