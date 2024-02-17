<?php

namespace App\Controller;

use App\Entity\Participants;
use Doctrine\ORM\EntityManagerInterface;
use Random\Randomizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ParticipantsController extends AbstractController
{
    #[Route('/participants', name: 'participants_index')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $participants = $entityManager->getRepository(Participants::class)->findAll();

        return $this->render('participants/index.html.twig', [
            'participants' => $participants,
        ]);
    }

    #[Route('/participants/show/{id}', name: 'participants_show')]
    public function show(EntityManagerInterface $entityManager, int $id): Response
    {
        $participant = $entityManager->getRepository(Participants::class)->find($id);

        if (!$participant) {
            throw $this->createNotFoundException('No participant found for id ' . $id);
        }

        return $this->render('participants/show.html.twig', ['participant' => $participant]);
    }

    #[Route('/participants/create', name: 'participants_create')]
    public function create(EntityManagerInterface $entityManager, ValidatorInterface $validator, Request $request): Response
    {
        $participant = $this->createParticipantFromFormData(new Participants(), $request);

        $errors = $validator->validate($participant);
        if (count($errors) > 0) {
            return new Response((string)$errors, 400);
        }

        $entityManager->persist($participant);
        $entityManager->flush();

        return $this->redirectToRoute('participants_show', [
            'id' => $participant->getId()
        ]);
    }

    /**
     * Attempts to fill a participant object with data from create/edit forms
     *
     * @param Participants $participant
     * @param Request $request
     * @return Participants|Response
     */
    protected function createParticipantFromFormData(Participants $participant, Request $request): Participants|Response
    {
        $formData = $request->getPayload()->all();

        try {
            $participant->setFirstname($formData['firstname']);
            $participant->setLastname($formData['lastname']);
            $participant->setEmail($formData['email']);
            $participant->setUnit($formData['unit']);
            if (!empty($formData['password'])) {
                $participant->setPassword(crypt($formData['password'], (new Randomizer())->getBytes(64)));
            }
        } catch (\Exception $e) {
            return new Response($e->getMessage(), 400);
        }

        return $participant;
    }

    #[Route('/participants/edit/{id}', name: 'participants_edit')]
    public function editParticipant(EntityManagerInterface $entityManager, int $id): Response
    {
        $participant = $entityManager->getRepository(Participants::class)->find($id);

        if (!$participant) {
            throw $this->createNotFoundException('No participants found for id ' . $id);
        }

        return $this->render('participants/edit.html.twig', ['participant' => $participant]);
    }

    #[Route('/participants/update', name: 'participants_update', methods: 'POST')]
    public function update(EntityManagerInterface $entityManager, ValidatorInterface $validator, Request $request): Response
    {
        $participant = $entityManager->getRepository(Participants::class)->find($request->getPayload()->get('id'));

        if (!$participant) {
            throw $this->createNotFoundException('No participants found for id ' . $request->getPayload()->get('id'));
        }

        $participant = $this->createParticipantFromFormData($participant, $request);

        $errors = $validator->validate($participant);
        if (count($errors) > 0) {
            return new Response((string)$errors, 400);
        }

        $entityManager->flush();

        return $this->redirectToRoute('participants_show', [
            'id' => $participant->getId()
        ]);
    }
    #[Route('/participants/remove/{id}', name: 'participants_remove')]
    public function deleteParticipant(EntityManagerInterface $entityManager, int $id): Response
    {
        $participant = $entityManager->getRepository(Participants::class)->find($id);

        if (!$participant) {
            throw $this->createNotFoundException('No participant found for id ' . $id);
        }

        return $this->render('participants/delete.html.twig', ['participant' => $participant]);
    }

    #[Route('/participants/delete', name: 'participants_delete', methods: 'POST')]
    public function delete(EntityManagerInterface $entityManager, Request $request): Response
    {
        $participant = $entityManager->getRepository(Participants::class)->find($request->getPayload()->get('id'));

        if (!$participant) {
            throw $this->createNotFoundException('No participant found for id ' . $request->getPayload()->get('id'));
        }

        $entityManager->remove($participant);
        $entityManager->flush();

        return $this->redirectToRoute('participants_index');
    }
}
