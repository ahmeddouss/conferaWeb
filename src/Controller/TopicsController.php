<?php

namespace App\Controller;

use App\Entity\Session;
use App\Entity\Topics;
use App\Form\TopicsType;
use App\Repository\TopicsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/topics')]
class TopicsController extends AbstractController
{
    #[Route('/', name: 'app_topics_index', methods: ['GET'])]
    public function index(TopicsRepository $topicsRepository): Response
    {
        return $this->render('topics/index.html.twig', [
            'topics' => $topicsRepository->findAll(),
        ]);
    }






    #[Route('/{id}/new', name: 'app_topics_new', methods: ['GET', 'POST'])]
    public function newby(Request $request,Session $session, EntityManagerInterface $entityManager): Response
    {
        $topic = new Topics();
        $topic->setIdSession($session); // Assuming setIdSession() is the method to set idsession in Topics entity

        $form = $this->createForm(TopicsType::class, $topic);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($topic);
            $entityManager->flush();

            return $this->redirectToRoute('app_session_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('topics/new.html.twig', [
            'topic' => $topic,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_topics_show', methods: ['GET'])]
    public function show(Topics $topic): Response
    {
        return $this->render('topics/show.html.twig', [
            'topic' => $topic,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_topics_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Topics $topic, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TopicsType::class, $topic);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_session_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('topics/edit.html.twig', [
            'topic' => $topic,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_topics_delete', methods: ['POST'])]
    public function delete(Request $request, Topics $topic, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$topic->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($topic);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_session_index', [], Response::HTTP_SEE_OTHER);
    }
}
