<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ActuRepository")
 */
class Actu
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $nouveaute;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNouveaute(): ?string
    {
        return $this->nouveaute;
    }

    public function setNouveaute(?string $nouveaute): self
    {
        $this->nouveaute = $nouveaute;

        return $this;
    }
}
