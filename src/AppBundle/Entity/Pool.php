<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="pools")
 
 */
class Pool 
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;  

    /**     
     * @ORM\OneToMany(targetEntity="votation", mappedBy="pool")
     */
    private $votations;


    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    

    /**
     * @return mixed
     */
    public function getSchudle()
    {
        return $this->schudle;
    }

    /**
     * @param mixed $schudle
     *
     * @return self
     */
    public function setSchudle($schudle)
    {
        $this->schudle = $schudle;

        return $this;
    }
}
