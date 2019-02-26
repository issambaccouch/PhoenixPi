<?php

namespace TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Participation
 *
 * @ORM\Table(name="participation", indexes={@ORM\Index(name="idws", columns={"idws"}), @ORM\Index(name="idadherent", columns={"idadherent"})})
 * @ORM\Entity
 */
class Participation
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="idadherent", type="integer", nullable=false)
     */
    private $idadherent;

    /**
     * @var integer
     *
     * @ORM\Column(name="idws", type="integer", nullable=false)
     */
    private $idws;



    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set idadherent
     *
     * @param integer $idadherent
     *
     * @return Participation
     */
    public function setIdadherent($idadherent)
    {
        $this->idadherent = $idadherent;

        return $this;
    }

    /**
     * Get idadherent
     *
     * @return integer
     */
    public function getIdadherent()
    {
        return $this->idadherent;
    }

    /**
     * Set idws
     *
     * @param integer $idws
     *
     * @return Participation
     */
    public function setIdws($idws)
    {
        $this->idws= $idws;

        return $this;
    }

    /**
     * Get idws
     *
     * @return integer
     */
    public function getIdws()
    {
        return $this->idws;
    }
}
