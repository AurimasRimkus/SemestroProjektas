<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="cars")
 * @ORM\Entity(repositoryClass="App\Repository\CarRepository")
 */
class Car
{
    /**
     * @ORM\Column(type="string", length=255)
     * @ORM\Id
     */
    private $numberPlate;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $model;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $engineType;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $transmission;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $power;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Profile", inversedBy="cars")
     * @ORM\JoinColumn(name="profile_id", referencedColumnName="id")
     */
    private $profile;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Order", mappedBy="car")
     */
    private $orders;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
    }

    public function getNumberPlate()
    {
        return $this->numberPlate;
    }

    public function setNumberPlate($numberPlate)
    {
        $this->numberPlate = $numberPlate;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getEngineType(): ?string
    {
        return $this->engineType;
    }

    public function setEngineType(string $engineType): self
    {
        $this->engineType = $engineType;

        return $this;
    }

    public function getTransmission(): ?string
    {
        return $this->transmission;
    }

    public function setTransmission(string $transmission): self
    {
        $this->transmission = $transmission;

        return $this;
    }

    public function getPower(): ?int
    {
        return $this->power;
    }

    public function setPower(?int $power): self
    {
        $this->power = $power;

        return $this;
    }

    public function getProfile(): Profile
    {
        return $this->profile;
    }

    public function setProfile(Profile $profile)
    {
        $this->profile = $profile;
    }

    public function getOrders()
    {
        return $this->orders;
    }

    public function addOrder(Order $order)
    {
        $this->orders->add($order);
    }
}
