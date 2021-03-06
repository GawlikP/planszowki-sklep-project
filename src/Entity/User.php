<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer", name="id")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Nick;

    /**
     * @ORM\Column(type="string", length=512)
     * @Assert\NotBlank
     */
    private $Password;

    /**
    * @ORM\Column(type="string", length=255)
    * @Assert\NotBlank
    **/
    private $Name;

    /**
    * @ORM\Column(type="string", length=255)
    * @Assert\NotBlank
    **/

    private $LastName;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     */
    private $Permission;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Email( message = "The email '{{value}}' is not a valid email."
     * )
     */
    private $email;

    

    public function __construct()
    {
        $this->orders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNick(): ?string
    {
        return $this->Nick;
    }

    public function setNick(string $Nick): self
    {
        $this->Nick = $Nick;

        return $this;
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
    public function getLastName(): ?string
    {
        return $this->LastName;
    }

    public function setLastName(string $LastName): self
    {
        $this->LastName = $LastName;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->Password;
    }

    public function setPassword(string $Password): self
    {
        $this->Password = $Password;

        return $this;
    }

    public function getPermission(): ?int
    {
        return $this->Permission;
    }

    public function setPermission(int $Permission): self
    {
        $this->Permission = $Permission;

        return $this;
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
     * @return Collection|Order[]
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders[] = $order;
            $order->setUser($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->contains($order)) {
            $this->orders->removeElement($order);
            // set the owning side to null (unless already changed)
            if ($order->getUser() === $this) {
                $order->setUser(null);
            }
        }

        return $this;
    }
}
