<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\NotBlank()
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email."
     * )
     */
    private $email;

    /**
     * @ORM\Column(type="json_array")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * * @Assert\NotBlank()
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     * * @Assert\NotBlank()
     */
    private $username;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 8,
     *      max = 8,
     *      minMessage = "le numero doit etre compose de 8 chiffres",
     *      maxMessage = "le numero doit etre compose de 8 chiffres"
     * )
     */
    private $userphone;

    /**
     * @ORM\Column(type="integer")
     *  @Assert\NotBlank()
     *  @Assert\Length(
     *      min = 8,
     *      max = 8,
     *      minMessage = "le numero doit etre compose de 8 chiffres",
     *      maxMessage = "le numero doit etre compose de 8 chiffres"
     * )
     */
    private $userCIN;

    /**
     * @ORM\Column(type="string", length=255)
     * * @Assert\NotBlank()
     */
    private $useradress;

    /**
     * @ORM\Column(type="date")
     */
    private $birthday;

    /**
     * @ORM\Column(type="string", length=255)
     * * @Assert\NotBlank()
     */
    private $userfirstname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $userlastname;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getUserphone(): ?int
    {
        return $this->userphone;
    }

    public function setUserphone(int $userphone): self
    {
        $this->userphone = $userphone;

        return $this;
    }

    public function getUserCIN(): ?int
    {
        return $this->userCIN;
    }

    public function setUserCIN(int $userCIN): self
    {
        $this->userCIN = $userCIN;

        return $this;
    }

    public function getUseradress(): ?string
    {
        return $this->useradress;
    }

    public function setUseradress(string $useradress): self
    {
        $this->useradress = $useradress;

        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getUserfirstname(): ?string
    {
        return $this->userfirstname;
    }

    public function setUserfirstname(string $userfirstname): self
    {
        $this->userfirstname = $userfirstname;

        return $this;
    }

    public function getUserlastname(): ?string
    {
        return $this->userlastname;
    }

    public function setUserlastname(string $userlastname): self
    {
        $this->userlastname = $userlastname;

        return $this;
    }
}
