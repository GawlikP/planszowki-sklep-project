<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderRepository")
 * @ORM\Table(name="`order`")
 */
class Order
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer", name="id")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $Order_Date;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $FinalizationDate;

    /**
    * @ORM\Column(type="string",length=255, nullable=true)
    **/

    private $Name;

    /**
     * @ORM\Column(type="string", length=1024)
     */
    private $Basket;

    /**
    * @ORM\Column(type="string", length=255)
    **/

    private $Payment;

    /**
     * @ORM\Column(type="decimal", precision=12, scale=2)
     */
    private $Price;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Status;

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrderDate(): ?\DateTimeInterface
    {
        return $this->Order_Date;
    }

    public function setOrderDate(\DateTimeInterface $Order_Date): self
    {
        $this->Order_Date = $Order_Date;

        return $this;
    }

    public function getFinalizationDate(): ?\DateTimeInterface
    {
        return $this->FinalizationDate;
    }

    public function setFinalizationDate(?\DateTimeInterface $FinalizationDate): self
    {
        $this->FinalizationDate = $FinalizationDate;

        return $this;
    }

    public function getBasket(): ?string
    {
        return $this->Basket;
    }

    public function setBasket(string $Basket): self
    {
        $this->Basket = $Basket;

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

    public function getStatus(): ?string
    {
        return $this->Status;
    }

    public function setStatus(?string $Status): self
    {
        $this->Status = $Status;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): self
    {
        $this->User = $User;

        return $this;
    }
}
