<?php

namespace App\Controller;

use App\Entity\Financialincomes;
use App\Form\FinancialincomesType;
use App\Repository\FinancialincomesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/financialincomes')]
class FinancialincomesController extends AbstractController
{
    #[Route('/', name: 'app_financialincomes_index', methods: ['GET'])]
    public function index(FinancialincomesRepository $financialincomesRepository): Response
    {
        return $this->render('financialincomes/index.html.twig', [
            'financialincomes' => $financialincomesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_financialincomes_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $financialincome = new Financialincomes();
        $form = $this->createForm(FinancialincomesType::class, $financialincome);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($financialincome);
            $entityManager->flush();

            return $this->redirectToRoute('app_financialincomes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('financialincomes/new.html.twig', [
            'financialincome' => $financialincome,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_financialincomes_show', methods: ['GET'])]
    public function show(Financialincomes $financialincome): Response
    {
        return $this->render('financialincomes/show.html.twig', [
            'financialincome' => $financialincome,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_financialincomes_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Financialincomes $financialincome, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FinancialincomesType::class, $financialincome);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_financialincomes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('financialincomes/edit.html.twig', [
            'financialincome' => $financialincome,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_financialincomes_delete', methods: ['POST'])]
    public function delete(Request $request, Financialincomes $financialincome, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$financialincome->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($financialincome);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_financialincomes_index', [], Response::HTTP_SEE_OTHER);
    }
}
