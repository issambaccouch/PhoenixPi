<?php

namespace TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tags
 *
 * @ORM\Table(name="tags")
 * @ORM\Entity
 */
class Tags
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idtag", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idtag;

    /**
     * @var string
     *
     * @ORM\Column(name="nomtag", type="string", length=255, nullable=true)
     */
    private $nomtag;



    /**
     * Get idtag
     *
     * @return integer
     */
    public function getIdtag()
    {
        return $this->idtag;
    }

    /**
     * Set nomtag
     *
     * @param string $nomtag
     *
     * @return Tags
     */
    public function setNomtag($nomtag)
    {
        $this->nomtag = $nomtag;

        return $this;
    }

    /**
     * Get nomtag
     *
     * @return string
     */
    public function getNomtag()
    {
        return $this->nomtag;
    }
}
