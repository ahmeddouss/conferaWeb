<?php

namespace App\Controller;

use App\Entity\Logisticincome;
use App\Form\LogisticincomeType;
use App\Repository\LogisticincomeRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/logisticincome')]
class LogisticincomeController extends AbstractController
{
    #[Route('/{LogisticID}', name: 'app_logisticincome_index', methods: ['GET'])]
    public function index( EntityManagerInterface $entityManager, $LogisticID ): Response
    {

        return $this->render('logisticincome/index.html.twig', [
            'logisticincomes' =>  $entityManager->getRepository(Logisticincome::class)->findBy(['logisticid' => $LogisticID]),
        ]);
    }

    #[Route('/new', name: 'app_logisticincome_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $logisticincome = new Logisticincome();
        $form = $this->createForm(LogisticincomeType::class, $logisticincome);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($logisticincome);
            $entityManager->flush();

            return $this->redirectToRoute('app_logisticincome_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('logisticincome/new.html.twig', [
            'logisticincome' => $logisticincome,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_logisticincome_show', methods: ['GET'])]
    public function show(Logisticincome $logisticincome): Response
    {
        return $this->render('logisticincome/show.html.twig', [
            'logisticincome' => $logisticincome,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_logisticincome_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Logisticincome $logisticincome, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LogisticincomeType::class, $logisticincome);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_logisticincome_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('logisticincome/edit.html.twig', [
            'logisticincome' => $logisticincome,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_logisticincome_delete', methods: ['POST'])]
    public function delete(Request $request, Logisticincome $logisticincome, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$logisticincome->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($logisticincome);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_logisticincome_index', [], Response::HTTP_SEE_OTHER);
    }
}
