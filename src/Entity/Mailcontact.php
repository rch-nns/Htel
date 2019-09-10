<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Mailcontact
{
    /**
     * @var string|null
     * @Assert\NotBlank
     * @Assert\Lenght(min=2, max=100)
     */
    private $firstname;

    /**
     * @var string|null
     * @Assert\NotBlank
     * @Assert\Lenght(min=2, max=100)
     */
    private $lastname;

    /**
     * @var string|null
     * @Assert\NotBlank
     * @Assert\Regex(
     * pattern="/[0-9]{10}/"
     * )
     */
    private $phone;

    /**
     * @var string|null
     * @Assert\NotBlank
     * @Assert\Email()
     */
    private $email;

    /**
     * @var string|null
     * @Assert\NotBlank
     * @Assert\Lenght(min=10)
     */
    private $message;

    /**
     * @return null|string
     */

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    /**
     * @param null|string $firstname
     * @return Contact
     */

    public function setFirstname(?string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * @return null|string
     */

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    /**
     * @param null|string $lastname
     * @return Contact
     */

    public function setLastname(?string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * @return null|string
     */

    public function getPhone(): ?int
    {
        return $this->phone;
    }

    /**
     * @param null|string $phone
     * @return Contact
     */

    public function setPhone(?int $tel): self
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return null|string
     */

    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param null|string $email
     * @return Contact
     */

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return null|string
     */

    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @param null|string $message
     * @return Contact
     */

    public function setMessage(?string $message): self
    {
        $this->message = $message;

        return $this;
    }

}