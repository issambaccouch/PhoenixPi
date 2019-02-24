<?php

namespace TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Question
 *
 * @ORM\Table(name="question")
 * @ORM\Entity
 */
class Question
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idq", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idq;

    /**
     * @var string
     *
     * @ORM\Column(name="textq", type="string", length=255, nullable=true)
     */
    private $textq;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateq", type="date", nullable=true)
     */
    private $dateq;


}

