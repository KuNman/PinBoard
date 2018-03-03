<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AreasRepository")
 */
class Areas
{

    public function __construct() {
        $this->city = new ArrayCollection();
    }

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, nullable=false, unique=false)
     */
    private $area;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Countries", inversedBy="area")
     * @ORM\JoinColumn(nullable=true)
     */
    private $country;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Tasks", mappedBy="area")
     */

    private $tasks;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getArea()
    {
        return $this->area;
    }

    /**
     * @param mixed $area
     */
    public function setArea($area)
    {
        $this->area = $area;
    }

    public function getCountry() : Countries {
        return $this->country;
    }

    public function setCountry(Countries $countries) {
        $this->country = $countries;
    }

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Cities", mappedBy="area")
     */
    private $city;

    /**
     * @return Collection\City[]
     */
    public function getCity() {
        return $this->city;
    }

    /**
     * @return Collection\Tasks[]
     */
    public function getTasks() {
        return $this->tasks;
    }

}
