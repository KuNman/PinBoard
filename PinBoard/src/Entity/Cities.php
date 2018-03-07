<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Count;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CitiesRepository")
 */
class Cities
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, nullable=false, unique=true)
     */
    private $city;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Areas", inversedBy="area")
     * @ORM\JoinColumn(nullable=true)
     */
    private $area;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Countries", inversedBy="country")
     * @ORM\JoinColumn(nullable=true)
     */
    private $country;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Tasks", mappedBy="city")
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
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    public function getArea() : Areas {
        return $this->area;
    }

    public function setArea(Areas $areas) {
        $this->area = $areas;
    }

    public function getCountry() : Countries {
        return $this->country;
    }

    public function setCountry(Countries $countries) {
        $this->country = $countries;
    }

    /**
     * @return Collection\Tasks[]
     */
    public function getTasks() {
        return $this->tasks;
    }


}
