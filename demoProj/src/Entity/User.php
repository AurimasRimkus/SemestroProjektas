<?php
namespace App\Entity;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="users")
 * @ORM\Entity
 * @UniqueEntity(fields={"email"}, message="This email is already taken. Please, choose different one.")
 * @UniqueEntity(fields={"username"}, message="This username is already taken. Please, choose different one.")
 */
class User implements UserInterface
{

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=255, nullable=false, unique=true)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false, unique=true)
     * @Assert\Email()
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=false)
     * @Assert\Length(
     *     min=6,
     *     minMessage = "Password must be at least {{ limit }} characters long"
     * )
     */
    private $password;

    /**
     * @var string
     *
     * @Assert\Length(
     *     min=6,
     *     minMessage = "New password must be at least {{ limit }} characters long"
     * )
     */
    private $newPassword;

    /**
     * @var string|null
     *
     * @ORM\Column(name="passwordResetToken", type="string", length=255, nullable=true)
     */
    private $passwordResetToken;

    // Role 1 = user; 2 = mechanic; 3 = admin
    /**
     * @var int
     *
     * @ORM\Column(name="role", type="integer", nullable=false)
     */
    private $role;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="registrationDate", type="datetime", nullable=false)
     */
    private $registrationDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="lastLoginTime", type="datetime", nullable=false)
     */
    private $lastLoginTime;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isDeleted;

    /**
     * @var string|null
     *
     * @ORM\Column(name="registrationToken", type="string", length=255, nullable=true)
     */
    private $registrationToken;

    /**
     * @return bool
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
     * @param null|string $passwordResetToken
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
