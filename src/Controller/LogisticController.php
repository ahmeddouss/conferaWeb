<?php

namespace App\Controller;

use App\Entity\Logistic;
use App\Form\LogisticType;
use App\Repository\LogisticRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/logistic')]
class LogisticController extends AbstractController
{
    #[Route('/', name: 'app_logistic_index', methods: ['GET'])]
    public function index(LogisticRepository $logisticRepository): Response
    {
        return $this->render('logistic/index.html.twig', [
            'logistics' => $logisticRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_logistic_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $logistic = new Logistic();
        $form = $this->createForm(LogisticType::class, $logistic);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($logistic);
            $entityManager->flush();

            return $this->redirectToRoute('app_logistic_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('logistic/new.html.twig', [
            'logistic' => $logistic,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_logistic_show', methods: ['GET'])]
    public function show(Logistic $logistic): Response
    {
        return $this->render('logistic/show.html.twig', [
            'logistic' => $logistic,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_logistic_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Logistic $logistic, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LogisticType::class, $logistic);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_logistic_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('logistic/edit.html.twig', [
            'logistic' => $logistic,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_logistic_delete', methods: ['POST'])]
    public function delete(Request $request, Logistic $logistic, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$logistic->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($logistic);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_logistic_index', [], Response::HTTP_SEE_OTHER);
    }
}
