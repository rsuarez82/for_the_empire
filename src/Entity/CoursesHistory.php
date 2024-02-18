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

    #[ORM\ManyToOne(targetEntity: Courses::class, inversedBy: 'id')]
    #[ORM\JoinColumn(name: 'course_id', referencedColumnName: 'id' ,nullable: false)]
    private ?Courses $course = null;

    #[ORM\ManyToOne(targetEntity: Participants::class, inversedBy: 'id')]
    #[ORM\JoinColumn(name: 'participant_id', referencedColumnName: 'id' ,nullable: false)]
    private ?Participants $participant = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCourse(): ?Courses
    {
        return $this->course;
    }

    public function setCourse(?Courses $course): static
    {
        $this->course = $course;

        return $this;
    }

    public function getParticipant(): ?Participants
    {
        return $this->participant;
    }

    public function setParticipant(?Participants $participant): static
    {
        $this->participant = $participant;

        return $this;
    }
}
