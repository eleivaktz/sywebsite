<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="games")
 
 */
class Game 
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $steamlink;
    /**
     * @ORM\Column(type="boolean", nullable=true, options={"default" : false})
     */
    protected $owned;
    /**
     * @ORM\Column(type="array", nullable=true)
     */
    protected $steaminfo;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $game_description;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    protected $game_images;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    protected $game_movies;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    protected $categories_array;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $header_image;


     /**     
     * @ORM\ManyToMany(targetEntity="Gamecategory")
     * @ORM\JoinTable(name="game_categories",
     *      joinColumns={@ORM\JoinColumn(name="game_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="gamecategory_id", referencedColumnName="id")}
     *      )
     */
    protected $categories;



    public function __toString()
    {
        return $this->name;
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     *
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSteamlink()
    {
        return $this->steamlink;
    }

    /**
     * @param mixed $steamlink
     *
     * @return self
     */
    public function setSteamlink($steamlink)
    {
        $this->steamlink = $steamlink;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @param mixed $categories
     *
     * @return self
     */
    public function setCategories($categories)
    {
        $this->categories = $categories;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getOwned()
    {
        return $this->owned;
    }

    /**
     * @param mixed $owned
     *
     * @return self
     */
    public function setOwned($owned)
    {
        $this->owned = $owned;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSteaminfo()
    {
        return array($this->steaminfo);
    }

    public function getPlainSteaminfo()
    {
        return $this->steaminfo;
    }

    /**
     * @param mixed $steaminfo
     *
     * @return self
     */
    public function setSteaminfo($steaminfo)
    {
        $this->steaminfo = $steaminfo;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getHeaderImage()
    {
        return $this->header_image;
    }

    /**
     * @param mixed $header_image
     *
     * @return self
     */
    public function setHeaderImage($header_image)
    {
        $this->header_image = $header_image;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCategoriesArray()
    {
        return array($this->categories_array);
    }

    /**
     * @param mixed $categories_array
     *
     * @return self
     */
    public function setCategoriesArray($categories_array)
    {
        $this->categories_array = $categories_array;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getGameMovies()
    {
        return array($this->game_movies);
    }

    /**
     * @param mixed $game_movies
     *
     * @return self
     */
    public function setGameMovies($game_movies)
    {
        $this->game_movies = $game_movies;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getGameImages()
    {
        return array($this->game_images);
    }

    /**
     * @param mixed $game_images
     *
     * @return self
     */
    public function setGameImages($game_images)
    {
        $this->game_images = $game_images;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getGameDescription()
    {
        return $this->game_description;
    }

    /**
     * @param mixed $game_description
     *
     * @return self
     */
    public function setGameDescription($game_description)
    {
        $this->game_description = $game_description;

        return $this;
    }
}
