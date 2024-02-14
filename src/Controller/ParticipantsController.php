<?php

namespace App\Controller;

use App\Entity\Participants;
use Doctrine\ORM\EntityManagerInterface;
use Random\Randomizer;
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
        $participant = $entityManager->getRepository(Participants::class)->find($id);

        if (!$participant) {
            throw $this->createNotFoundException(
                'No participant found for id ' . $id
            );
        }

        return $this->render('participant/show.html.twig', ['participant' => $participant]);
    }

    #[Route('/participants/create', name: 'participants_create')]
    public function create(EntityManagerInterface $entityManager, ValidatorInterface $validator): Response
    {
        $participant = new Participants();
        $participant = $this->createParticipantFromFormData($participant, $this->container->get('parameter_bag')->all());

        $errors = $validator->validate($participant);
        if (count($errors) > 0) {
            return new Response((string) $errors, 400);
        }

        $entityManager->persist($participant);
        $entityManager->flush();

        return new Response('success', 200);
    }

    #[Route('/participants/edit/{id}', name: 'participants_edit')]
    public function update(EntityManagerInterface $entityManager, ValidatorInterface $validator, int $id): Response
    {
        $participant = $entityManager->getRepository(Participants::class)->find($id);

        if (!$participant) {
            throw $this->createNotFoundException(
                'No participants found for id ' . $id
            );
        }

        $participant = $this->createParticipantFromFormData($participant, $this->container->get('parameter_bag')->all());

        $errors = $validator->validate($participant);
        if (count($errors) > 0) {
            return new Response((string) $errors, 400);
        }

        $entityManager->flush();

        return $this->redirectToRoute('participants_show', [
            'id' => $participant->getId()
        ]);
    }

    #[Route('/participants/delete/{id}', name: 'participants_delete')]
    public function delete(EntityManagerInterface $entityManager, int $id): Response
    {
        $participant = $entityManager->getRepository(Participants::class)->find($id);

        $entityManager->remove($participant);
        $entityManager->flush();

        return $this->redirectToRoute('participants_index');
    }

    /**
     * Attempts to fill a participant object with data from the parameter bag
     *
     * @param Participants $participant
     * @param array $formData
     * @return Participants
     */
    protected function createParticipantFromFormData(Participants $participant, array $formData): Participants
    {
        $participant->setFirstname($formData['title']);
        $participant->setLastname($formData['courseDate']);
        $participant->setEmail($formData['content']);
        $participant->setUnit($formData['description']);
        $participant->setPassword(crypt($formData['courseLeader'], (new Randomizer())->getBytes(64)));

        return $participant;
    }
}
