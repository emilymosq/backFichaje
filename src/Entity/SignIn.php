<?php

namespace App\Entity;

use App\Repository\SignInRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SignInRepository::class)]
class SignIn
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::ARRAY)]
    private array $hoursignin = [];

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $localitation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $comment = null;

    #[ORM\Column]
    private ?bool $updated = null;

    #[ORM\ManyToOne(inversedBy: 'usersignin')]
    private ?User $signinuser = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHoursignin(): array
    {
        return $this->hoursignin;
    }

    public function setHoursignin(array $hoursignin): self
    {
        $this->hoursignin = $hoursignin;

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

    public function getSigninuser(): ?User
    {
        return $this->signinuser;
    }

    public function setSigninuser(?User $signinuser): self
    {
        $this->signinuser = $signinuser;

        return $this;
    }
}
