<?php

namespace App\Controller;

use App\Entity\Courses;
use App\Entity\CoursesHistory;
use App\Entity\Participants;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CoursesHistoryController extends AbstractController
{
    #[Route('/courses_history', name: 'courses_history_index')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $courses = $entityManager->getRepository(Courses::class)->findAll();
        $participants = $entityManager->getRepository(Participants::class)->findAll();

        return $this->render('courses_history/index.html.twig', [
            'courses' => $courses,
            'participants' => $participants,
        ]);
    }

    #[Route('/courses_history/list_by_participant/{id}', name: 'courses_history_by_participant')]
    public function listByParticipant(EntityManagerInterface $entityManager, int $id): Response
    {
        $courses = $entityManager->getRepository(CoursesHistory::class)
            ->findCoursesHistoryByParticipantId($id);

        if (empty($courses)) {
            throw $this->createNotFoundException('No history entries found for participant ' . $id);
        }

        return $this->render('courses_history/by_participant.html.twig', ['courses' => $courses]);
    }

    #[Route('/courses_history/list_by_course/{id}', name: 'courses_history_by_course')]
    public function listByCourse(EntityManagerInterface $entityManager, int $id): Response
    {
        $participants = $entityManager->getRepository(CoursesHistory::class)
            ->findCoursesHistoryByCourseId($id);

        if (empty($participants)) {
            throw $this->createNotFoundException('No history entries found for course ' . $id);
        }

        return $this->render('courses_history/by_course.html.twig', ['participants' => $participants]);
    }
}
