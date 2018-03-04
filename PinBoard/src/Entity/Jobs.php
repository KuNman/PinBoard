<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\JobsRepository")
 */
class Jobs
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
    private $name;

    /**
     * @ORM\Column(type="string", length=100, nullable=false, unique=false)
     */
    private $name_pl;

    /**
     * @ORM\Column(type="string", length=100, nullable=false, unique=false)
     */
    private $name_fr;

    /**
     * @return mixed
     */
    public function getNamePl()
    {
        return $this->name_pl;
    }

    /**
     * @param mixed $name_pl
     */
    public function setNamePl($name_pl)
    {
        $this->name_pl = $name_pl;
    }

    /**
     * @return mixed
     */
    public function getNameFr()
    {
        return $this->name_fr;
    }

    /**
     * @param mixed $name_fr
     */
    public function setNameFr($name_fr)
    {
        $this->name_fr = $name_fr;
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Tasks", mappedBy="job")
     */
    private $tasks;

    /**
     * @return Collection\Jobs[]
     */
    public function getTasks() {
        return $this->tasks;
    }

}
