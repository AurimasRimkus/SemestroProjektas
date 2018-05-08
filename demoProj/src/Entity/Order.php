<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @ORM\Column(name="startDate", type="datetime", nullable=false)
     * @Assert\DateTime()
     */
    private $startDate;

    /**
     * @ORM\Column(name="finishDate", type="datetime", nullable=false)
     * @Assert\DateTime()
     */
    private $finishDate;

    /**
     * @ORM\Column(name="duration", type="integer", nullable=false)
     * @Assert\Type("integer")
     */
    private $duration;

    /**
     * @ORM\Column(name="isDone", type="boolean", nullable=false)
     * @Assert\Type("bool")
     */
    private $isDone;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Profile", inversedBy="orders")
     * @ORM\JoinColumn(name="profile_id", referencedColumnName="id")
     */
    private $profile;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Car", inversedBy="orders")
     * @ORM\JoinColumn(name="car_id", referencedColumnName="number_plate")
     */
    private $car;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Repair", mappedBy="order")
     */
    private $repairs;

    /**
     * @ORM\Column(name="comment", type="text", nullable=true)
     * @Assert\Type("string")
     */
    private $comment;

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
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * @param mixed $duration
     * @return Order
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @param mixed $startDate
     * @return Order
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFinishDate()
    {
        return $this->finishDate;
    }

    /**
     * @param mixed $finishDate
     * @return Order
     */
    public function setFinishDate($finishDate)
    {
        $this->finishDate = $finishDate;
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
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param $comment
     * @return $this
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
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
