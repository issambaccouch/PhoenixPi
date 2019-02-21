<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Produit
 *
 * @ORM\Table(name="produit", indexes={@ORM\Index(name="iduser", columns={"iduser"}), @ORM\Index(name="idcp", columns={"idcp"}), @ORM\Index(name="idpromo", columns={"idpromo"})})
 * @ORM\Entity
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
     * @var \Promotion
     *
     * @ORM\ManyToOne(targetEntity="Promotion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idpromo", referencedColumnName="idpromo")
     * })
     */
    private $idpromo;


}

