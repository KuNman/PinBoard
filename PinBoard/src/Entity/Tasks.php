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

    private $country;

    private $area;

    private $city;

    private $price;

    public function getJob() : Jobs {
        return $this->job;
    }

    public function setJob(Jobs $jobs) {
        $this->job = $jobs;
    }
}
