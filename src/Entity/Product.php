<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     *
     */
    private $Name;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     * @Assert\NotBlank
     * @Assert\Type(
     *	type="numeric",
     *	message="The value {{value}} is not a valid double."
     * )
     */
    private $Price;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     * @Assert\Type(
     *	type="integer",
     *	message="The value {{value}} is not a valid integer."
     * )
     * @Assert\Range(
     *	min = 1,
     *	max = 32,
     *	minMessage = "Players must be at least 1",
     *	maxMessage = "Players cannot be over 32"
     * )
     */
    private $Player;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     * @Assert\Type(
     *	type="integer",
     *	message="The Player limit should be integer type."
     * )
     * @Assert\Range(
     *	min = 1,
     *	max = 110,
     *	minMessage = "Your age must be at least 1.",
     *	maxMessage = "Your age cannot be more than 32." 
     * )
     */
    private $Age;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $Company;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank
     */
    private $Descrioption;

    /**
     * @ORM\Column(type="integer")
     */
    private $Count;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->Price;
    }

    public function setPrice(string $Price): self
    {
        $this->Price = $Price;

        return $this;
    }

    public function getPlayer(): ?int
    {
        return $this->Player;
    }

    public function setPlayer(int $Player): self
    {
        $this->Player = $Player;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->Age;
    }

    public function setAge(int $Age): self
    {
        $this->Age = $Age;

        return $this;
    }

    public function getCompany(): ?string
    {
        return $this->Company;
    }

    public function setCompany(string $Company): self
    {
        $this->Company = $Company;

        return $this;
    }

    public function getDescrioption(): ?string
    {
        return $this->Descrioption;
    }

    public function setDescrioption(string $Descrioption): self
    {
        $this->Descrioption = $Descrioption;

        return $this;
    }

    public function getCount(): ?int
    {
        return $this->Count;
    }

    public function setCount(int $Count): self
    {
        $this->Count = $Count;

        return $this;
    }
}
