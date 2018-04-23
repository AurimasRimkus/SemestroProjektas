<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Table(name="orders")
 * @ORM\Entity(repositoryClass="App\Repository\OrderRepository")
 */
class Order
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="arrivalDate", type="datetime", nullable=false)
     */
    private $arrivalDate;

    /**
     * @ORM\Column(name="isDone", type="boolean", nullable=false)
     */
    private $isDone;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Profile", inversedBy="orders")
     * @ORM\JoinColumn(name="profile_id", referencedColumnName="id")
     */
    private $profile;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Car", inversedBy="order")
     * @ORM\JoinColumn(name="car_id", referencedColumnName="number_plate")
     */
    private $car;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Repair", mappedBy="order")
     */
    private $repairs;

    public function __construct()
    {
        $this->repairs = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getProfile()
    {
        return $this->profile;
    }

    /**
     * @param mixed $profile
     */
    public function setProfile($profile)
    {
        $this->profile = $profile;
    }

    /**
     * @return mixed
     */
    public function getRepairs()
    {
        return $this->repairs;
    }

    /**
     * @param mixed $repair
     */
    public function addRepairs(Repair $repair)
    {
        $this->repairs->add($repair);
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
     * @return Order
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getArrivalDate()
    {
        return $this->arrivalDate;
    }

    /**
     * @param mixed $arrivalDate
     * @return Order
     */
    public function setArrivalDate($arrivalDate)
    {
        $this->arrivalDate = $arrivalDate;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIsDone()
    {
        return $this->isDone;
    }

    /**
     * @param mixed $isDone
     * @return Order
     */
    public function setIsDone($isDone)
    {
        $this->isDone = $isDone;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUser(): User
    {
        return $this->profile;
    }

    /**
     * @param mixed $profile
     */
    public function setUser($profile)
    {
        $this->profile = $profile;
    }

    /**
     * @return Car
     */
    public function getCar(): Car
    {
        return $this->car;
    }

    /**
     * @param $car
     */
    public function setCar($car)
    {
        $this->car = $car;
    }
}
