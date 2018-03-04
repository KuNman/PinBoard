<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TasksRepository")
 */
class Tasks
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Jobs", inversedBy="task")
     * @ORM\JoinColumn(nullable=false)
     */
    private $job;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Countries", inversedBy="country")
     * @ORM\JoinColumn(nullable=false)
     */
    private $country;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Areas", inversedBy="area")
     * @ORM\JoinColumn(nullable=false)
     */
    private $area;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Cities", inversedBy="city")
     * @ORM\JoinColumn(nullable=true)
     */
    private $city;

    /**
     * @ORM\Column(type="integer", length=10, nullable=false, unique=false)
     */
    private $price;

    /**
     * @ORM\Column(type="date", nullable=false, unique=false)
     */
    private $avaibility;

    /**
     * @return mixed
     */
    public function getAvaibility()
    {
        return $this->avaibility;
    }

    /**
     * @param mixed $avaibility
     */
    public function setAvaibility($avaibility)
    {
        $this->avaibility = $avaibility;
    }

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Users", inversedBy="username")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="boolean",nullable=false, unique=false)
     */
    private $active;

    /**
     * @return mixed
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param mixed $active
     */
    public function setActive($active)
    {
        $this->active = $active;
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
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function getJob() : Jobs {
        return $this->job;
    }

    public function setJob(Jobs $jobs) {
        $this->job = $jobs;
    }

    public function getCountry() : Countries {
        return $this->country;
    }

    public function setCountry(Countries $countries) {
        $this->country = $countries;
    }

    public function getArea() : Areas {
        return $this->area;
    }

    public function setArea(Areas $areas) {
        $this->area = $areas;
    }

    public function getCity() : Cities {
        return $this->city;
    }

    public function setCity(Cities $cities) {
        $this->city = $cities;
    }

    public function getUser() : Users {
        return $this->user;
    }

    public function setUser(Users $users) {
        $this->user = $users;
    }
}
