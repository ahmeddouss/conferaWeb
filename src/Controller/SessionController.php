<?php

namespace App\Controller;

use App\Entity\Session;
use App\Form\SessionType;
use App\Repository\SessionRepository;
use App\Repository\TopicsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/session')]
class SessionController extends AbstractController
{
    #[Route('/', name: 'app_session_index', methods: ['GET'])]
    public function index(SessionRepository $sessionRepository): Response
    {
        return $this->render('session/index.html.twig', [
            'sessions' => $sessionRepository->findAll(),
        ]);
    }


    #[Route('/front', name: 'app_front_index', methods: ['GET'])]
    public function indexfront(SessionRepository $sessionRepository): Response
    {
        return $this->render('session/front.html.twig', [
            'sessions' => $sessionRepository->findAll(),
        ]);
    }

    #[Route('/chart', name: 'app_session_chart', methods: ['GET'])]
    public function chart(SessionRepository $sessionRepository): Response
    {
        return $this->render('session/chart.html.twig', [
            'sessions' => $sessionRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_session_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $session = new Session();
        $form = $this->createForm(SessionType::class, $session);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($session);
            $entityManager->flush();

            return $this->redirectToRoute('app_session_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('session/new.html.twig', [
            'session' => $session,
            'form' => $form,
        ]);
    }


    #[Route('/{id}', name: 'app_session_show', methods: ['GET'])]
    public function show(int $id, SessionRepository $sessionRepository, TopicsRepository $topicsRepository): Response
    {
        $session = $sessionRepository->find($id); // Fetch the session entity by ID
        if (!$session) {
            throw $this->createNotFoundException('Session not found');
        }

        $topics = $topicsRepository->findByExampleField($id); // Assuming findByExampleField is a custom method in your TopicsRepository

        return $this->render('session/show.html.twig', [
            'session' => $session,
            'topics' => $topics,
        ]);
    }




    #[Route('/{id}/edit', name: 'app_session_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Session $session, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SessionType::class, $session);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->flush();

            return $this->redirectToRoute('app_session_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('session/edit.html.twig', [
            'session' => $session,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_session_delete', methods: ['POST'])]
    public function delete(Request $request, Session $session, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$session->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($session);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_session_index', [], Response::HTTP_SEE_OTHER);
    }


}
