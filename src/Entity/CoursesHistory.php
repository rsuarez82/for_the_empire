<?php

namespace App\Entity;

use App\Repository\CoursesHistoryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CoursesHistoryRepository::class)]
class CoursesHistory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'id')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Courses $courseId = null;

    #[ORM\ManyToOne(inversedBy: 'id')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Participants $participantId = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCourseId(): ?Courses
    {
        return $this->courseId;
    }

    public function setCourseId(?Courses $courseId): static
    {
        $this->courseId = $courseId;

        return $this;
    }

    public function getParticipantId(): ?Participants
    {
        return $this->participantId;
    }

    public function setParticipantId(?Participants $participantId): static
    {
        $this->participantId = $participantId;

        return $this;
    }
}
