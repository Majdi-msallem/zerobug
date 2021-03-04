<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\ORM\Mapping as ORM;
use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=CommandeRepository::class)
 */
class Commande
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $dateCommande;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank()
     */
    private $montantCommande;



    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="commandes")
     */
    private $client;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateCommande(): ?DateTimeInterface
    {
        return $this->dateCommande;
    }

    public function setDateCommande(DateTimeInterface $dateCommande): self
    {
        $this->dateCommande = $dateCommande;

        return $this;
    }

    public function getMontantCommande(): ?float
    {
        return $this->montantCommande;
    }

    public function setMontantCommande(float $montantCommande): self
    {
        $this->montantCommande = $montantCommande;

        return $this;
    }


    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }
    public function __toString(){
        return(string)$this->getId();
    }

}
