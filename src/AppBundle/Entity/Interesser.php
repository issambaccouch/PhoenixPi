<?php

namespace AppBundle\Entity;

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
     * @ORM\ManyToOne(targetEntity="FosUser")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="iduser", referencedColumnName="id")
     * })
     */
    private $iduser;


}

