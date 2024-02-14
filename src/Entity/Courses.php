<?php

namespace App\Entity;

use App\Repository\CoursesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CoursesRepository::class)]
class Courses
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[ORM\OneToMany(targetEntity: CoursesHistory::class, mappedBy: 'courseId', orphanRemoval: true)]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $courseDate = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $courseLeader = null;

    #[ORM\Column]
    private ?int $freeSlots = 0;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getCourseDate(): ?\DateTimeInterface
    {
        return $this->courseDate;
    }

    public function setCourseDate(\DateTimeInterface $courseDate): static
    {
        $this->courseDate = $courseDate;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getCourseLeader(): ?string
    {
        return $this->courseLeader;
    }

    public function setCourseLeader(string $courseLeader): static
    {
        $this->courseLeader = $courseLeader;

        return $this;
    }

    public function getFreeSlots(): ?int
    {
        return $this->freeSlots;
    }

    public function setFreeSlots(int $freeSlots): static
    {
        $this->freeSlots = $freeSlots;

        return $this;
    }
}
