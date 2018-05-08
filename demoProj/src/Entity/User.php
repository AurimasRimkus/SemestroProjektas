<?php
namespace App\Entity;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * User
 *
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields={"email"}, message="This email is already taken. Please, choose different one.")
 * @UniqueEntity(fields={"username"}, message="This username is already taken. Please, choose different one.")
 */
class User implements UserInterface
{

    /**
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\Column(name="username", type="string", length=255, nullable=false, unique=true)
     * @Assert\Type("string")
     */
    private $username;

    /**
     * @ORM\Column(name="email", type="string", length=255, nullable=false, unique=true)
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(name="password", type="string", length=255, nullable=false)
     * @Assert\Length(
     *     min=6,
     *     minMessage = "Password must be at least {{ limit }} characters long"
     * )
     */
    private $password;

    /**
     * @Assert\Length(
     *     min=6,
     *     minMessage = "New password must be at least {{ limit }} characters long"
     * )
     */
    private $newPassword;

    /**
     * @ORM\Column(name="passwordResetToken", type="string", length=255, nullable=true)
     * @Assert\Type("string")
     */
    private $passwordResetToken;

    // Role 1 = user; 2 = mechanic; 3 = admin
    /**
     * @ORM\Column(name="role", type="integer", nullable=false)
     * @Assert\Range(
     *     min = 1,
     *     max = 3
     * )
     */
    private $role;

    /**
     * @ORM\Column(name="registrationDate", type="datetime", nullable=false)
     * @Assert\DateTime()
     */
    private $registrationDate;

    /**
     * @ORM\Column(name="lastLoginTime", type="datetime", nullable=false)
     * @Assert\DateTime()
     */
    private $lastLoginTime;

    /**
     * @ORM\Column(type="boolean")
     * @Assert\Type("bool")
     */
    private $isActive;

    /**
     * @ORM\Column(type="boolean")
     * @Assert\Type("bool")
     */
    private $isDeleted;

    /**
     * @ORM\Column(name="registrationToken", type="string", length=255, nullable=true)
     * @Assert\Type("string")
     */
    private $registrationToken;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Profile", mappedBy="user")
     */
    private $profile;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getNewPassword()
    {
        return $this->newPassword;
    }

    /**
     * @param string $newPassword
     */
    public function setNewPassword(string $newPassword)
    {
        $this->newPassword = $newPassword;
    }

    /**
     * @return null|string
     */
    public function getPasswordResetToken()
    {
        return $this->passwordResetToken;
    }

    /**
     * @param null|string $passwordResetTokenProfile
     */
    public function setPasswordResetToken($passwordResetToken)
    {
        $this->passwordResetToken = $passwordResetToken;
    }

    /**
     * @return int
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param int $role
     */
    public function setRole(int $role)
    {
        $this->role = $role;
    }

    /**
     * @return \DateTime
     */
    public function getRegistrationDate()
    {
        return $this->registrationDate;
    }

    /**
     * @param \DateTime $registrationDate
     */
    public function setRegistrationDate(\DateTime $registrationDate)
    {
        $this->registrationDate = $registrationDate;
    }

    /**
     * @return \DateTime
     */
    public function getLastLoginTime()
    {
        return $this->lastLoginTime;
    }

    /**
     * @param \DateTime $lastLoginTime
     */
    public function setLastLoginTime(\DateTime $lastLoginTime)
    {
        $this->lastLoginTime = $lastLoginTime;
    }

    /**
     * @return mixed
     */
    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    /**
     * @param mixed $isActive
     */
    public function setIsActive(bool $isActive)
    {
        $this->isActive = $isActive;
    }

    /**
     * @return mixed
     */
    public function getIsDeleted(): ?bool
    {
        return $this->isDeleted;
    }

    /**
     * @param mixed $isDeleted
     */
    public function setIsDeleted(bool $isDeleted)
    {
        $this->isDeleted = $isDeleted;
    }

    /**
     * @return null|string
     */
    public function getRegistrationToken()
    {
        return $this->registrationToken;
    }

    /**
     * @param null|string $passwordResetToken
     */
    public function setRegistrationToken($registrationToken)
    {
        $this->registrationToken = $registrationToken;
    }

    public function getProfile(): Profile
    {
        return $this->profile;
    }

    public function setProfile(Profile $profile)
    {
        $this->profile = $profile;
    }

    /**
     * @return mixed
     */
    public function getOrders(): Order
    {
        return $this->orders;
    }

    /**
     * @param mixed $orders
     */
    public function setOrders($orders)
    {
        $this->orders = $orders;
    }

    public function getSalt()
    {
        return null;
    }

    public function getRoles()
    {
        return array ('ROLE_USER');
    }

    public function eraseCredentials()
    {
    }
}
