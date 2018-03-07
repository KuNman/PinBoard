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
     * @ORM\Column(type="json_array", nullable=false, unique=false)
     */
    private $city;

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

    /**
     * @ORM\Column(type="date", nullable=false, unique=false)
     */
    private $availability;

    /**
     * @return mixed
     */
    public function getAvailability()
    {
        return $this->availability;
    }

    /**
     * @param mixed $availability
     */
    public function setAvailability($availability)
    {
        $this->availability = $availability;
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

    public function getUser() : Users {
        return $this->user;
    }

    public function setUser(Users $users) {
        $this->user = $users;
    }
}
