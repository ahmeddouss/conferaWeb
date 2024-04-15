<?php

namespace App\Controller;

use App\Entity\Estimatedexpenses;
use App\Form\EstimatedexpensesType;
use App\Repository\EstimatedexpensesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/estimatedexpenses')]
class EstimatedexpensesController extends AbstractController
{
    #[Route('/', name: 'app_estimatedexpenses_index', methods: ['GET'])]
    public function index(EstimatedexpensesRepository $estimatedexpensesRepository): Response
    {
        return $this->render('estimatedexpenses/index.html.twig', [
            'estimatedexpenses' => $estimatedexpensesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_estimatedexpenses_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $estimatedexpense = new Estimatedexpenses();
        $form = $this->createForm(EstimatedexpensesType::class, $estimatedexpense);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($estimatedexpense);
            $entityManager->flush();
            return $this->redirectToRoute('app_estimatedexpenses_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('estimatedexpenses/new.html.twig', [
            'estimatedexpense' => $estimatedexpense,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_estimatedexpenses_show', methods: ['GET'])]
    public function show(Estimatedexpenses $estimatedexpense): Response
    {
        return $this->render('estimatedexpenses/show.html.twig', [
            'estimatedexpense' => $estimatedexpense,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_estimatedexpenses_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Estimatedexpenses $estimatedexpense, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EstimatedexpensesType::class, $estimatedexpense);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_estimatedexpenses_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('estimatedexpenses/edit.html.twig', [
            'estimatedexpense' => $estimatedexpense,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_estimatedexpenses_delete', methods: ['POST'])]
    public function delete(Request $request, Estimatedexpenses $estimatedexpense, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$estimatedexpense->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($estimatedexpense);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_estimatedexpenses_index', [], Response::HTTP_SEE_OTHER);
    }
}
