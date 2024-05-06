<?php

namespace App\Controller;

use App\Entity\Incomes;
use App\Form\IncomesType;
use App\Repository\IncomesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/incomes')]
class IncomesController extends AbstractController
{
    #[Route('/', name: 'app_incomes_index', methods: ['GET'])]
    public function index(IncomesRepository $incomesRepository): Response
    {
        return $this->render('incomes/index.html.twig', [
            'incomes' => $incomesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_incomes_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $income = new Incomes();
        $form = $this->createForm(IncomesType::class, $income);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($income);
            $entityManager->flush();

            return $this->redirectToRoute('app_incomes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('incomes/new.html.twig', [
            'income' => $income,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_incomes_show', methods: ['GET'])]
    public function show(Incomes $income): Response
    {
        return $this->render('incomes/show.html.twig', [
            'income' => $income,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_incomes_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Incomes $income, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(IncomesType::class, $income);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_incomes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('incomes/edit.html.twig', [
            'income' => $income,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_incomes_delete', methods: ['POST'])]
    public function delete(Request $request, Incomes $income, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$income->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($income);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_incomes_index', [], Response::HTTP_SEE_OTHER);
    }
}
