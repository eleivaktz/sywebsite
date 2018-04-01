<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="votations")
 
 */
class Votation 
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;  

    /**
     * @ORM\ManyToOne(targetEntity="Pool", inversedBy="votations")
     * @ORM\JoinColumn(name="pool_id", referencedColumnName="id")
     */
    private $pool;

    /**     
     * @ORM\OneToOne(targetEntity="Game")
     * @ORM\JoinColumn(name="game_id", referencedColumnName="id")
     */
    private $game; 

    /**     
     * @ORM\Column(type="integer")     
     */
    private $votes;


     /**     
     * @ORM\ManyToMany(targetEntity="User")
     * @ORM\JoinTable(name="users_votation",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="votation_id", referencedColumnName="id", unique=true)}
     *      )
     */
    private $voters;

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
    public function getPool()
    {
        return $this->pool;
    }

    /**
     * @param mixed $schudle
     *
     * @return self
     */
    public function setPool($pool)
    {
        $this->pool = $pool;

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
    public function setGame($game)
    {
        $this->game = $game;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVotes()
    {
        return $this->votes;
    }

    /**
     * @param mixed $votes
     *
     * @return self
     */
    public function setVotes($votes)
    {
        $this->votes = $votes;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVoters()
    {
        return $this->voters;
    }

    /**
     * @param mixed $voters
     *
     * @return self
     */
    public function setVoters($voters)
    {
        $this->voters = $voters;

        return $this;
    }
}
