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
            throw $this->createNotFoundException(
                'No course found for id '.$id
            );
        }

        return new Response('Check out this great course: '.$course->getName());

        // or render a template
        // in the template, print things with {{ product.name }}
        // return $this->render('product/show.html.twig', ['product' => $product]);
    }

    #[Route('/courses/create', name: 'courses_create')]
    public function createProduct(ValidatorInterface $validator): Response
    {
        $course = new Courses();

        // ... update the product data somehow (e.g. with a form) ...

        $errors = $validator->validate($course);
        if (count($errors) > 0) {
            return new Response((string) $errors, 400);
        }

        return new Response('success', 200);
    }

    #[Route('/courses/edit/{id}', name: 'courses_edit')]
    public function update(EntityManagerInterface $entityManager, int $id): Response
    {
        $course = $entityManager->getRepository(Courses::class)->find($id);

        if (!$course) {
            throw $this->createNotFoundException(
                'No courses found for id '.$id
            );
        }

        $course->setName('New courses name!');
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
