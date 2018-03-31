<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="schudlegameday")
 
 */
class Schudlegameday 
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /** 
     * @ORM\Column(type="string", columnDefinition="ENUM('lunes', 'martes','miercoles','jueves','viernes','sabado','domingo')") 
     */    
    private $day;

    /**     
     * @ORM\OneToOne(targetEntity="Game")
     * @ORM\JoinColumn(name="game_id", referencedColumnName="id")
     */
    private $game;

    /**     
     * @ORM\ManyToOne(targetEntity="Schudle", inversedBy="schudlegamedays")
     * @ORM\JoinColumn(name="schudle_id", referencedColumnName="id")
     */
    private $schudle;

    /**
     * @return mixed
     */
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
    public function getDay()
    {
        return $this->day;
    }

    /**
     * @param mixed $day
     *
     * @return self
     */
    public function setDay($day)
    {
        $this->day = $day;

        return $this;
    }

    /**
     * @param mixed $game
     *
     * @return self
     */
    public function setGame($game)
    {
        $this->game = $game;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getGame()
    {
        return $this->game;
    }

    /**
     * @param mixed $game
     *
     * @return self
     */


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

    public function __toString()    
    {
        if($this->game)
        {
            return $this->day." ".$this->game->__toString();
        }
        else
        {
            return $this->day;
        }
    }
}
