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
use Symfony\Component\Validator\Validator\ValidatorInterface;

class BookingController extends AbstractController
{
    #[Route('/booking', name: 'booking_index')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $courses = $entityManager->getRepository(Courses::class)->findAll();
        $participants = $entityManager->getRepository(Participants::class)->findAll();

        return $this->render('booking/index.html.twig', [
            'courses' => $courses,
            'participants' => $participants,
        ]);
    }

    #[Route('/booking/create', name: 'booking_create', methods: 'POST')]
    public function create(EntityManagerInterface $entityManager, ValidatorInterface $validator, Request $request): Response
    {
        $courseHistory = new CoursesHistory();

        $course = $entityManager->getRepository(Courses::class)->find($request->getPayload()->get('courseId'));
        $participant = $entityManager->getRepository(Participants::class)->find($request->getPayload()->get('participantId'));

        $courseHistory->setCourse($course);
        $courseHistory->setParticipant($participant);

        $errors = $validator->validate($courseHistory);
        if (count($errors) > 0) {
            return new Response((string)$errors, 400);
        }

        $entityManager->persist($courseHistory);
        $entityManager->flush();

        $this->addFlash('string', 'Booking saved!');
        return $this->redirectToRoute('booking_index');
    }
}
