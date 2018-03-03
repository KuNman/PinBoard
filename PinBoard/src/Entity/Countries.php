<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CountriesRepository")
 */
class Countries
{

    public function __construct() {
        $this->areas = new ArrayCollection();
    }

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, nullable=false, unique=true)
     */
    private $country;

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
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param mixed $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Areas", mappedBy="country")
     */
    private $areas;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Cities", mappedBy="country")
     */
    private $cities;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Tasks", mappedBy="country")
     */

    private $tasks;

    /**
     * @return Collection\Area[]
     */
    public function getAreas() {
        return $this->areas;
    }

    /**
     * @return Collection\Cities[]
     */
    public function getCities() {
        return $this->cities;
    }

    /**
     * @return Collection\Tasks[]
     */
    public function getTasks() {
        return $this->tasks;
    }

}
