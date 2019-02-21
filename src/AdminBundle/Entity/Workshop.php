<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Workshop
 *
 * @ORM\Table(name="workshop", indexes={@ORM\Index(name="iduser", columns={"iduser"}), @ORM\Index(name="idcw", columns={"idcw"})})
 * @ORM\Entity
 */
class Workshop
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idws", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
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


}

