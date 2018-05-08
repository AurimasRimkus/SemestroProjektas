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
     * @Assert\Regex(
     *     pattern = "/\W+/",
     *     match = false,
     *     message = "Car number plate cannot contain special symbols."
     * )
     */
    private $numberPlate;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Assert\Regex(
     *     pattern = "/[\d\W]+/",
     *     match = false,
     *     message = "Car model cannot contain digits or special character"
     * )
     */
    private $model;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Assert\Type("string")
     */
    private $engineType;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Assert\Type("string")
     */
    private $transmission;

    /**
     * @ORM\Column(type="integer", nullable=false)
     * @Assert\Range(
     *     min = 0,
     *     max = 1000,
     *     minMessage = "Engine power cannot be negative.",
     *     maxMessage = "Engine power is too high."
     * )
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
