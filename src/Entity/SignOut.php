<?php

namespace App\Entity;

use App\Repository\SignOutRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SignOutRepository::class)]
class SignOut
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::ARRAY)]
    private array $hoursignout = [];

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $localitation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $comment = null;

    #[ORM\Column]
    private ?bool $updated = null;

    #[ORM\ManyToOne(inversedBy: 'usersignout')]
    private ?User $signoutuser = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHoursignout(): array
    {
        return $this->hoursignout;
    }

    public function setHoursignout(array $hoursignout): self
    {
        $this->hoursignout = $hoursignout;

        return $this;
    }

    public function getLocalitation(): ?string
    {
        return $this->localitation;
    }

    public function setLocalitation(?string $localitation): self
    {
        $this->localitation = $localitation;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function isUpdated(): ?bool
    {
        return $this->updated;
    }

    public function setUpdated(bool $updated): self
    {
        $this->updated = $updated;

        return $this;
    }

    public function getSignoutuser(): ?User
    {
        return $this->signoutuser;
    }

    public function setSignoutuser(?User $signoutuser): self
    {
        $this->signoutuser = $signoutuser;

        return $this;
    }
}
