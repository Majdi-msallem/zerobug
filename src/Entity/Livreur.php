<?php

namespace App\Entity;

use App\Repository\LivreurRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LivreurRepository::class)
 */
class Livreur
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomliv;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenomliv;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $numliv;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $planning;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomliv(): ?string
    {
        return $this->nomliv;
    }

    public function setNomliv(string $nomliv): self
    {
        $this->nomliv = $nomliv;

        return $this;
    }

    public function getPrenomliv(): ?string
    {
        return $this->prenomliv;
    }

    public function setPrenomliv(string $prenomliv): self
    {
        $this->prenomliv = $prenomliv;

        return $this;
    }

    public function getNumliv(): ?string
    {
        return $this->numliv;
    }

    public function setNumliv(string $numliv): self
    {
        $this->numliv = $numliv;

        return $this;
    }

    public function getPlanning(): ?string
    {
        return $this->planning;
    }

    public function setPlanning(string $planning): self
    {
        $this->planning = $planning;

        return $this;
    }
}
