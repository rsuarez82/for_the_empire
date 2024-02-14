<?php

namespace App\Controller;

use App\Entity\Participants;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ParticipantsController extends AbstractController
{
    #[Route('/participants', name: 'participants_index')]
    public function index(): Response
    {
        return $this->render('participants/index.html.twig', [
            'controller_name' => 'ParticipantsController',
        ]);
    }

    #[Route('/participants/{id}', name: 'participants_show')]
    public function show(EntityManagerInterface $entityManager, int $id): Response
    {
        $course = $entityManager->getRepository(Participants::class)->find($id);

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

    #[Route('/participants/create', name: 'participants_create')]
    public function createProduct(ValidatorInterface $validator): Response
    {
        $course = new Participants();

        // ... update the product data somehow (e.g. with a form) ...

        $errors = $validator->validate($course);
        if (count($errors) > 0) {
            return new Response((string) $errors, 400);
        }

        return new Response('success', 200);
    }

    #[Route('/participants/edit/{id}', name: 'participants_edit')]
    public function update(EntityManagerInterface $entityManager, int $id): Response
    {
        $course = $entityManager->getRepository(Participants::class)->find($id);

        if (!$course) {
            throw $this->createNotFoundException(
                'No courses found for id '.$id
            );
        }

        $course->setName('New courses name!');
        $entityManager->flush();

        return $this->redirectToRoute('participants_show', [
            'id' => $course->getId()
        ]);
    }

    #[Route('/participants/delete/{id}', name: 'participants_delete')]
    public function delete(EntityManagerInterface $entityManager, int $id): Response
    {
        $course = $entityManager->getRepository(Participants::class)->find($id);

        $entityManager->remove($course);
        $entityManager->flush();

        return $this->redirectToRoute('participants_index');
    }
}
