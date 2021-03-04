<?php

namespace App\Entity;

use App\Repository\PromotionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PromotionRepository::class)
 */
class Promotion
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $idpromotion;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nompromotion;

    /**
     * @ORM\Column(type="integer")
     */
    private $prixpromotion;

    /**
     * @ORM\Column(type="float")
     */
    private $remise;

    /**
     * @ORM\ManyToOne(targetEntity=Article::class, inversedBy="promotions")
     */
    private $articles;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;




    public function getIdpromotion(): ?int
    {
        return $this->idpromotion;
    }

    public function setIdpromotion(int $idpromotion): self
    {
        $this->idpromotion = $idpromotion;

        return $this;
    }

    public function getNompromotion(): ?string
    {
        return $this->nompromotion;
    }

    public function setNompromotion(string $nompromotion): self
    {
        $this->nompromotion = $nompromotion;

        return $this;
    }

    public function getPrixpromotion(): ?int
    {
        return $this->prixpromotion;
    }

    public function setPrixpromotion(int $prixpromotion): self
    {
        $this->prixpromotion = $prixpromotion;

        return $this;
    }

    public function getRemise(): ?float
    {
        return $this->remise;
    }

    public function setRemise(float $remise): self
    {
        $this->remise = $remise;

        return $this;
    }

    public function getArticles(): ?Article
    {
        return $this->articles;
    }

    public function setArticles(?Article $articles): self
    {
        $this->articles = $articles;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

}
