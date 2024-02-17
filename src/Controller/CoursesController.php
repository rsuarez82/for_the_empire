<?php

namespace App\Controller;

use App\Entity\Courses;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerExceptionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CoursesController extends AbstractController
{
    #[Route('/courses', name: 'courses_index')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $courses = $entityManager->getRepository(Courses::class)->findAll();

        return $this->render('courses/index.html.twig', [
            'courses' => $courses
        ]);
    }

    #[Route('/courses/show/{id}', name: 'courses_show', methods: 'GET')]
    public function show(EntityManagerInterface $entityManager, int $id): Response
    {
        $course = $entityManager->getRepository(Courses::class)->find($id);

        if (!$course) {
            throw $this->createNotFoundException('No course found for id ' . $id);
        }

        return $this->render('courses/show.html.twig', ['course' => $course]);
    }

    #[Route('/courses/create', name: 'courses_create', methods: 'POST')]
    public function create(ValidatorInterface $validator, EntityManagerInterface $entityManager, Request $request): Response
    {
        $course = $this->createCourseFromFormData(new Courses(), $request);

        $errors = $validator->validate($course);
        if (count($errors) > 0) {
            return new Response((string)$errors, 400);
        }

        $entityManager->persist($course);
        $entityManager->flush();

        return $this->redirectToRoute('courses_show', [
            'id' => $course->getId()
        ]);
    }

    /**
     * Attempts to fill a course object with data from the create/edit forms
     *
     * @param Courses $course
     * @param array $formData
     * @return Courses|Response
     */
    protected function createCourseFromFormData(Courses $course, Request $request): Courses|Response
    {
        $formData = $request->getPayload();
        try {
            $course->setTitle($formData->get('title'));
            $course->setCourseDate(new \DateTime($formData->get('courseDate')));
            $course->setContent($formData->get('content'));
            $course->setDescription($formData->get('description'));
            $course->setCourseLeader($formData->get('courseLeader'));
            $course->setFreeSlots($formData->get('freeSlots'));
        } catch (\Exception $e) {
            return new Response($e->getMessage(), 400);
        }

        return $course;
    }

    #[Route('/courses/edit/{id}', name: 'courses_edit')]
    public function editCourse(EntityManagerInterface $entityManager, int $id): Response
    {
        $course = $entityManager->getRepository(Courses::class)->find($id);

        if (!$course) {
            throw $this->createNotFoundException('No courses found for id ' . $id);
        }

        return $this->render('courses/edit.html.twig', ['course' => $course]);
    }

    #[Route('/courses/update', name: 'courses_update', methods: 'POST')]
    public function update(ValidatorInterface $validator, EntityManagerInterface $entityManager, Request $request): Response
    {
        $course = $entityManager->getRepository(Courses::class)->find($request->getPayload()->get('id'));

        if (!$course) {
            throw $this->createNotFoundException('No courses found for id ' . $request->getPayload()->get('id'));
        }
        $course = $this->createCourseFromFormData($course, $request);

        $errors = $validator->validate($course);
        if (count($errors) > 0) {
            return new Response((string)$errors, 400);
        }

        $entityManager->flush();

        return $this->redirectToRoute('courses_show', [
            'id' => $course->getId()
        ]);
    }

    #[Route('/courses/remove/{id}', name: 'courses_remove')]
    public function deleteCourse(EntityManagerInterface $entityManager, int $id): Response
    {
        $course = $entityManager->getRepository(Courses::class)->find($id);

        if (!$course) {
            throw $this->createNotFoundException('No courses found for id ' . $id);
        }

        return $this->render('courses/edit.html.twig', ['course' => $course]);
    }

    #[Route('/courses/delete', name: 'courses_delete', methods: 'POST')]
    public function delete(EntityManagerInterface $entityManager, Request $request): Response
    {
        $course = $entityManager->getRepository(Courses::class)->find($request->getPayload()->get('id'));

        $entityManager->remove($course);
        $entityManager->flush();

        return $this->redirectToRoute('courses_index');
    }
}
