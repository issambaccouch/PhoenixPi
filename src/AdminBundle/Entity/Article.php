<?php

namespace AdminBundle\Entity;

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
     * @var string
     *
     * @ORM\Column(name="videoart", type="string", length=255, nullable=true)
     */
    private $videoart;

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


}

