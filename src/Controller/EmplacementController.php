<?php

namespace App\Controller;

use App\Entity\Emplacement;
use App\Form\EmplacementType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\EmplacementRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/emplacement')]
class EmplacementController extends AbstractController
{
    #[Route('/', name: 'app_emplacement_index', methods: ['GET'])]
    public function index(Request $request, EmplacementRepository $emplacementRepository, PaginatorInterface $paginator): Response
    {
        {
            $searchQuery = $request->query->get('q');
            $sortBy = $request->query->get('sortBy', 'gouvernourat'); // Default sort by name
            $sortOrder = $request->query->get('sortOrder', 'asc'); // Default sort order is ascending
            // Get query for all emplacements or search by query
            $query = $emplacementRepository->searchAndSortQuery($searchQuery, $sortBy, $sortOrder);
    
            // Paginate the query
            $emplacements = $paginator->paginate(
                $query, // Query to paginate
                $request->query->getInt('page', 1), // Get page number from the request, default to 1
                5 // Number of items per page
            );

    
            return $this->render('emplacement/index.html.twig', [
                'emplacements' => $emplacements,
                'searchQuery' => $searchQuery,
                'sortBy' => $sortBy,
                'sortOrder' => $sortOrder,
            ]);
        }
    }

    #[Route('/new', name: 'app_emplacement_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $emplacement = new Emplacement();
        $form = $this->createForm(EmplacementType::class, $emplacement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($emplacement);
            $entityManager->flush();

            return $this->redirectToRoute('app_emplacement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('emplacement/new.html.twig', [
            'emplacement' => $emplacement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_emplacement_show', methods: ['GET'])]
    public function show(Emplacement $emplacement): Response
    {
        return $this->render('emplacement/show.html.twig', [
            'emplacement' => $emplacement,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_emplacement_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Emplacement $emplacement, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EmplacementType::class, $emplacement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_emplacement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('emplacement/edit.html.twig', [
            'emplacement' => $emplacement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_emplacement_delete', methods: ['POST'])]
    public function delete(Request $request, Emplacement $emplacement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$emplacement->getId(), $request->request->get('_token'))) {
            $entityManager->remove($emplacement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_emplacement_index', [], Response::HTTP_SEE_OTHER);
    }
}
