<?php

namespace TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Followers
 *
 * @ORM\Table(name="followers", indexes={@ORM\Index(name="idcw", columns={"idcw"}), @ORM\Index(name="idadherent", columns={"idadherent"}), @ORM\Index(name="idformateur", columns={"idformateur"})})
 * @ORM\Entity
 */
class Followers
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idfoll", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idfoll;

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
     * @var \FosUser
     *
     * @ORM\ManyToOne(targetEntity="FosUser")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idadherent", referencedColumnName="id")
     * })
     */
    private $idadherent;

    /**
     * @var \FosUser
     *
     * @ORM\ManyToOne(targetEntity="FosUser")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idformateur", referencedColumnName="id")
     * })
     */
    private $idformateur;


}

