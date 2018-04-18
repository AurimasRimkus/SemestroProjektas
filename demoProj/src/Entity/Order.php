<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

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
    private $arivalDate;

    /**
     * @ORM\Column(name="isDone", type="boolean", nullable=false)
     */
    private $isDone;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @ORM\Id
     */
    private $numberPlate;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $model;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $engineType;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $transmission;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $power;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="orders")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

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
    public function getArivalDate()
    {
        return $this->arivalDate;
    }

    /**
     * @param mixed $arivalDate
     * @return Order
     */
    public function setArivalDate($arivalDate)
    {
        $this->arivalDate = $arivalDate;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getisDone()
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
    public function getNumberPlate()
    {
        return $this->numberPlate;
    }

    /**
     * @param mixed $numberPlate
     * @return Order
     */
    public function setNumberPlate($numberPlate)
    {
        $this->numberPlate = $numberPlate;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param mixed $model
     * @return Order
     */
    public function setModel($model)
    {
        $this->model = $model;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEngineType()
    {
        return $this->engineType;
    }

    /**
     * @param mixed $engineType
     * @return Order
     */
    public function setEngineType($engineType)
    {
        $this->engineType = $engineType;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTransmission()
    {
        return $this->transmission;
    }

    /**
     * @param mixed $transmission
     * @return Order
     */
    public function setTransmission($transmission)
    {
        $this->transmission = $transmission;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPower()
    {
        return $this->power;
    }

    /**
     * @param mixed $power
     * @return Order
     */
    public function setPower($power)
    {
        $this->power = $power;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }
}
