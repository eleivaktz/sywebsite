<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="schudles")
 
 */
class Schudle 
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="integer")
     */
    protected $mes;
    /**
     * @ORM\Column(type="integer")
     */
    protected $ano;

    /**
     * @ORM\ManyToMany(targetEntity="Game")
     * @ORM\JoinTable(name="schudle_game",
     *      joinColumns={@ORM\JoinColumn(name="schudle_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="game_id", referencedColumnName="id")}
     *      )
     */
    private $games;

    /**     
     * @ORM\OneToMany(targetEntity="Schudlegameday", mappedBy="schudle")
     */
    private $schudlegamedays;
    
    public function __toString(){
        return "Mes:".$this->mes." Año:".$this->ano;
    }


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
    public function getMes()
    {
        return $this->mes;
    }

    /**
     * @param mixed $mes
     *
     * @return self
     */
    public function setMes($mes)
    {
        $this->mes = $mes;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAno()
    {
        return $this->ano;
    }

    /**
     * @param mixed $ano
     *
     * @return self
     */
    public function setAno($ano)
    {
        $this->ano = $ano;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getGames()
    {
        return $this->games;
    }

    /**
     * @param mixed $games
     *
     * @return self
     */
    public function setGames($games)
    {
        $this->games = $games;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSchudlegamedays()
    {
        return $this->schudlegamedays;
    }

    /**
     * @param mixed $schudlegamedays
     *
     * @return self
     */
    public function setSchudlegamedays($schudlegamedays)
    {
        $this->schudlegamedays = $schudlegamedays;

        return $this;
    }


    /**
     * Add schudlegamedays
     *
     * @param \AppBundle\Entity\Schudlegameday $schudlegamedays
     * @return Schudlegameday
     */
    public function addSchudlegamedays(\AppBundle\Entity\Schudlegameday $sgd)
    {
        if (!$this->schudlegamedays->contains($sgd)) {
            $this->schudlegamedays[] = $sgd;
            $sgd->addCategory($this);
        }

        return $this;
    }

    /**
     * Remove posts
     *
     * @param \AppBundle\Entity\Post $posts
     */
    public function removeSchudlegamedays(\AppBundle\Entity\Schudlegameday $sgd)
    {
        $this->schudlegamedays->removeElement($sgd);
        $sgd->removeCategory($this);
    }
}
