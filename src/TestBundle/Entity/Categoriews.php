<?php

namespace TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Categoriews
 *
 * @ORM\Table(name="categoriews")
 * @ORM\Entity
 */
class Categoriews
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idcw", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idcw;

    /**
     * @var string
     *
     * @ORM\Column(name="nomcws", type="string", length=255, nullable=true)
     */
    private $nomcws;


}

