<?php

namespace App\Controller;

use App\Entity\Courses;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

    #[Route('/courses/{id}', name: 'courses_show')]
    public function show(EntityManagerInterface $entityManager, int $id): Response
    {
        $course = $entityManager->getRepository(Courses::class)->find($id);

        if (!$course) {
            throw $this->createNotFoundException('No course found for id ' . $id);
        }

        return $this->render('courses/show.html.twig', ['course' => $course]);
    }

    #[Route('/courses/create', name: 'courses_create')]
    public function create(ValidatorInterface $validator, EntityManagerInterface $entityManager): Response
    {
        $course = $this->createCourseFromFormData(
            new Courses(),
            $this->container->get('parameter_bag')->all()
        );

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
     * Attempts to fill a course object with data from the parameter bag
     *
     * @param Courses $course
     * @param array $formData
     * @return Courses
     */
    protected function createCourseFromFormData(Courses $course, array $formData): Courses
    {
        $course->setTitle($formData['title']);
        $course->setCourseDate($formData['courseDate']);
        $course->setContent($formData['content']);
        $course->setDescription($formData['description']);
        $course->setCourseLeader($formData['courseLeader']);
        $course->setFreeSlots($formData['freeSlots']);

        return $course;
    }

    #[Route('/courses/edit/{id}', name: 'courses_edit')]
    public function update(ValidatorInterface $validator, EntityManagerInterface $entityManager, int $id): Response
    {
        $course = $entityManager->getRepository(Courses::class)->find($id);

        if (!$course) {
            throw $this->createNotFoundException('No courses found for id ' . $id);
        }

        $course = $this->createCourseFromFormData($course, $this->container->get('parameter_bag')->all());

        $errors = $validator->validate($course);
        if (count($errors) > 0) {
            return new Response((string)$errors, 400);
        }

        $entityManager->flush();

        return $this->redirectToRoute('courses_show', [
            'id' => $course->getId()
        ]);
    }

    #[Route('/courses/delete/{id}', name: 'courses_delete')]
    public function delete(EntityManagerInterface $entityManager, int $id): Response
    {
        $course = $entityManager->getRepository(Courses::class)->find($id);

        $entityManager->remove($course);
        $entityManager->flush();

        return $this->redirectToRoute('courses_index');
    }
}
