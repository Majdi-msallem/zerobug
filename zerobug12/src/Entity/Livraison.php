<?php

namespace App\Entity;

use App\Repository\LivraisonRepository;
use Doctrine\ORM\Mapping as ORM;
use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=LivraisonRepository::class)
 */
class Livraison
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     *  @Assert\NotBlank()
     */
    private $DateLiv;

    /**
     * @ORM\ManyToOne(targetEntity=Livreur::class, inversedBy="livraisons")
     * @ORM\JoinColumn(nullable=false)
     *  @Assert\NotBlank()
     */
    private $Livreur;

    /**
     * @ORM\ManyToOne(targetEntity=Commande::class, inversedBy="livraisons")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank()
     */
    private $Commande;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateLiv(): ?DateTimeInterface
    {
        return $this->DateLiv;
    }

    public function setDateLiv(DateTimeInterface $DateLiv): self
    {
        $this->DateLiv = $DateLiv;

        return $this;
    }

    public function getLivreur(): ?Livreur
    {
        return $this->Livreur;
    }

    public function setLivreur(?Livreur $Livreur): self
    {
        $this->Livreur = $Livreur;

        return $this;
    }

    public function getCommande(): ?Commande
    {
        return $this->Commande;
    }

    public function setCommande(?Commande $Commande): self
    {
        $this->Commande = $Commande;

        return $this;
    }


}
