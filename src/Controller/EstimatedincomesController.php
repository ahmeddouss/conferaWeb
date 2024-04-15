<?php

namespace App\Controller;

use App\Entity\Estimatedincomes;
use App\Form\EstimatedincomesType;
use App\Repository\EstimatedincomesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/estimatedincomes')]
class EstimatedincomesController extends AbstractController
{
    #[Route('/', name: 'app_estimatedincomes_index', methods: ['GET'])]
    public function index(EstimatedincomesRepository $estimatedincomesRepository): Response
    {
        return $this->render('estimatedincomes/index.html.twig', [
            'estimatedincomes' => $estimatedincomesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_estimatedincomes_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $estimatedincome = new Estimatedincomes();
        $form = $this->createForm(EstimatedincomesType::class, $estimatedincome);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($estimatedincome);
            $entityManager->flush();

            return $this->redirectToRoute('app_estimatedincomes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('estimatedincomes/new.html.twig', [
            'estimatedincome' => $estimatedincome,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_estimatedincomes_show', methods: ['GET'])]
    public function show(Estimatedincomes $estimatedincome): Response
    {
        return $this->render('estimatedincomes/show.html.twig', [
            'estimatedincome' => $estimatedincome,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_estimatedincomes_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Estimatedincomes $estimatedincome, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EstimatedincomesType::class, $estimatedincome);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_estimatedincomes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('estimatedincomes/edit.html.twig', [
            'estimatedincome' => $estimatedincome,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_estimatedincomes_delete', methods: ['POST'])]
    public function delete(Request $request, Estimatedincomes $estimatedincome, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$estimatedincome->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($estimatedincome);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_estimatedincomes_index', [], Response::HTTP_SEE_OTHER);
    }
}
