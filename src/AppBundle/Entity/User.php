<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User extends BaseUser
{

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=500)
     */
    protected $steam;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $twitch;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $facebook;
    /**
     * @ORM\Column(type="string", length=100)
     */
    
    


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
    public function getSteam()
    {
        return $this->steam;
    }

    /**
     * @param mixed $steam
     *
     * @return self
     */
    public function setSteam($steam)
    {
        $this->steam = $steam;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTwitch()
    {
        return $this->twitch;
    }

    /**
     * @param mixed $twitch
     *
     * @return self
     */
    public function setTwitch($twitch)
    {
        $this->twitch = $twitch;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFacebook()
    {
        return $this->facebook;
    }

    /**
     * @param mixed $facebook
     *
     * @return self
     */
    public function setFacebook($facebook)
    {
        $this->facebook = $facebook;

        return $this;
    }
}
