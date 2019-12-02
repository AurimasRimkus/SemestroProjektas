<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ServiceRepository")
 * @ORM\Table(name="services")
 */
class Service
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer", name="id", type="integer", nullable=false)
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=false, unique=true)
     * @Assert\Type("string")
     */
    private $name;

    /**
     * @ORM\Column(type="integer", nullable=false)
     * @Assert\Range(
     *     min = 1,
     *     max = 10000,
     *     minMessage = "Service's cost can not be negative or equal to 0",
     *     maxMessage = "Service's cost is too high"
     * )
     */
    private $cost;

    /**
     * @ORM\Column(type="integer", nullable=false)
     * @Assert\Range(
     *     min = 1,
     *     max = 5,
     *     minMessage = "Service must be at least 1 hour long",
     *     maxMessage = "Service must not exceed 5 hour long"
     * )
     */
    private $duration;

    /**
     * @ORM\Column(type="boolean")
     * @Assert\Type("bool")
     */
    private $isActive;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getCost()
    {
        return $this->cost;
    }

    public function setCost($cost)
    {
        $this->cost = $cost;

        return $this;
    }

    public function getDuration()
    {
        return $this->duration;
    }

    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    public function getIsActive()
    {
        return $this->isActive;
    }

    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }
}
