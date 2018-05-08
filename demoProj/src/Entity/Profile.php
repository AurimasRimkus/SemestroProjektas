<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="profiles")
 * @ORM\Entity(repositoryClass="App\Repository\ProfileRepository")
 */
class Profile
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Regex(
     *     pattern="/[\d. \W]+/",
     *     match=false,
     *     message="Your name cannot contain a digit or special character."
     * )
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Regex(
     *     pattern="/[\d. \W]+/",
     *     match=false,
     *     message="Your name cannot contain a digit or special character."
     * )
     */
    private $secondName;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Regex(
     *     pattern="/^\+?\d+/",
     *     match=true,
     *     message="Your phone number must only contain digits."
     * )
     */
    private $phoneNumber;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Assert\Date()
     */
    private $birthDate;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Car", mappedBy="profile")
     */
    private $cars;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", inversedBy="profile")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Order", mappedBy="profile")
     */
    private $orders;

    public function getId()
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSecondName(): ?string
    {
        return $this->secondName;
    }

    public function setSecondName(string $secondName): self
    {
        $this->secondName = $secondName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(?\DateTimeInterface $birthDate): self
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function __construct()
    {
        $this->cars = new ArrayCollection();
        $this->orders = new ArrayCollection();
    }

    /**
     * @return Collection|Car[]
     */
    public function getCars()
    {
        return $this->cars;
    }

    public function addCar(Car $car)
    {
        $this->cars->add($car);
    }

    /**
     * @return Collection|Order[]
     */
    public  function getOrders()
    {
        return $this->orders;
    }

    public function addOrder(Order $order)
    {
        $this->orders->add($order);
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user)
    {
        $this->user = $user;
    }

}
