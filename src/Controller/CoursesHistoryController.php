<?php

namespace App\Controller;

use App\Entity\Courses;
use App\Entity\CoursesHistory;
use App\Entity\Participants;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/courses_history/list_by_participant', name: 'courses_history_by_participant', methods: 'POST')]
    public function listByParticipant(EntityManagerInterface $entityManager, Request $request): Response
    {
        $courses = $entityManager->getRepository(CoursesHistory::class)
            ->findCoursesHistoryByParticipantId($request->getPayload()->get('participantId'));

        if (empty($courses)) {
            throw $this->createNotFoundException('No history entries found for participant ' . $request->getPayload()->get('participantId'));
        }

        return $this->render('courses_history/by_participant.html.twig', ['courses' => (object)$courses]);
    }

    #[Route('/courses_history/list_by_course', name: 'courses_history_by_course', methods: 'POST')]
    public function listByCourse(EntityManagerInterface $entityManager, Request $request): Response
    {
        $participants = $entityManager->getRepository(CoursesHistory::class)
            ->findCoursesHistoryByCourseId($request->getPayload()->get('courseId'));

        if (empty($participants)) {
            throw $this->createNotFoundException('No history entries found for course ' . $request->getPayload()->get('courseId'));
        }

        return $this->render('courses_history/by_course.html.twig', ['participants' => (object)$participants]);
    }
}
