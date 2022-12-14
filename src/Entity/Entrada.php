<?php

namespace App\Entity;

use App\Repository\EntradaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EntradaRepository::class)]
class Entrada
{

    const FICHAJE_EXITOSO = 'Tu fichaje se ha realizado exitosamente';

    const TYPES = [
        'Talent Garden - Madrid' => 'Madrid',
        'Factoría F5 - Barcelona' => 'Barcelona',
        'Teletrabajo' => 'Teletrabajo'
    ];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $fecha_publicacion = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $comentario = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $foto = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $locacion = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'entrada')]
    private $user;

    /**
     * Entrada constructor.
     */
    public function __construct()
    {
        $this->fecha_publicacion = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFechaPublicacion(): ?\DateTimeInterface
    {
        return $this->fecha_publicacion;
    }

    public function setFechaPublicacion(\DateTimeInterface $fecha_publicacion): self
    {
        $this->fecha_publicacion = $fecha_publicacion;

        return $this;
    }

    public function getComentario(): ?string
    {
        return $this->comentario;
    }

    public function setComentario(?string $comentario): self
    {
        $this->comentario = $comentario;

        return $this;
    }

    public function getFoto(): ?string
    {
        return $this->foto;
    }

    public function setFoto(string $foto): self
    {
        $this->foto = $foto;

        return $this;
    }

    public function getLocacion(): ?string
    {
        return $this->locacion;
    }

    public function setLocacion(?string $locacion): self
    {
        $this->locacion = $locacion;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
    }

    public function __toString()
    {
        return $this->getLocacion();
    }
}
