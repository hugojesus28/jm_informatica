<?php

class Service
{

    private ?int $idService = null;
    private string $description;
    private float $price;
    private ?string $createdAt = null;
    private ?string $updatedAt = null;
    private ?string $finishedAt = null;
    private ?float $commissionUser = null;
    private int $userIdUser;
    private string $userName = '';
    private ?User $user = null;

    public function __construct(?int $id = null, int $userIdUser = 0, string $description = '', float $price = 0.0) {
        $this->idService = $id;
        $this->userIdUser = $userIdUser;
        $this->description = $description;
        $this->price = $price;
    }

    public function getIdService(): ?int
    {
        return $this->idService;
    }

    public function setIdService(int $idService): void
    {
        $this->idService = $idService;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    public function setCreatedAt(string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?string $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function getFinishedAt(): ?string
    {
        return $this->finishedAt;
    }

    public function setFinishedAt(?string $finishedAt): void
    {
        $this->finishedAt = $finishedAt;
    }

    public function getCommissionUser(): ?float
    {
        return $this->commissionUser;
    }

    public function setCommissionUser(?float $commissionUser): void
    {
        $this->commissionUser = $commissionUser;
    }

    public function getUserIdUser(): int
    {
        return $this->userIdUser;
    }

    public function setUserIdUser(int $userIdUser): void
    {
        $this->userIdUser = $userIdUser;
    }
    public function getUserName(): string
    {
        return $this->userName;
    }

    public function setUserName(string $userName): void
    {
        $this->userName = $userName;
    }
    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }
    /**
     * Quando um serviço não ter data de finalização é automaticamente finalizado
     */
    public function isFinished(): bool
    {
        return $this->finishedAt !== null;
    }

}