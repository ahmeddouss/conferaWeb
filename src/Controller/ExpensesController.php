<?php

namespace App\Controller;

use App\Entity\Expenses;
use App\Form\ExpensesType;
use App\Repository\ExpensesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use Dompdf\Dompdf;
use Dompdf\Options;

#[Route('/expenses')]
class ExpensesController extends AbstractController
{
    #[Route('/', name: 'app_expenses_index', methods: ['GET'])]
    public function index(ExpensesRepository $expensesRepository): Response
    {
        $expenses = $expensesRepository->findAll();

    // Prepare data for Chart.js
    $labels = [];
    $data = [];

    foreach ($expenses as $expense) {
        $labels[] = $expense->getOnwhat();
        $data[] = $expense->getExpammount();
    }

    // Convert data to JSON format
    $chartData = [
        'labels' => $labels,
        'data' => $data,
    ];

        // Render the template with the data
    return $this->render('expenses/index.html.twig', [
        'chartData' => json_encode($chartData), // Pass the chart data to the Twig template
        'expenses' => $expenses,
    ]);
    }

    #[Route('/new', name: 'app_expenses_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $expense = new Expenses();
        $form = $this->createForm(ExpensesType::class, $expense);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($expense);
            $entityManager->flush();

            return $this->redirectToRoute('app_expenses_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('expenses/new.html.twig', [
            'expense' => $expense,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_expenses_show', methods: ['GET'])]
    public function show(Expenses $expense): Response
    {
        return $this->render('expenses/show.html.twig', [
            'expense' => $expense,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_expenses_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Expenses $expense, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ExpensesType::class, $expense);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_expenses_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('expenses/edit.html.twig', [
            'expense' => $expense,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_expenses_delete', methods: ['POST'])]
    public function delete(Request $request, Expenses $expense, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$expense->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($expense);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_expenses_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/export/pdf', name: 'app_expenses_export_pdf', methods: ['GET'])]
public function exportPdf(ExpensesRepository $expensesRepository): Response
{
    $expenses = $expensesRepository->findAll();

    $html = $this->renderView('expenses/pdf.html.twig', [
        'expenses' => $expenses,
    ]);

    // Configure Dompdf options
    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);

    // Instantiate Dompdf with our options
    $dompdf = new Dompdf($options);

    // Load HTML content
    $dompdf->loadHtml($html);

    // (Optional) Set the paper size and orientation
    $dompdf->setPaper('A4', 'portrait');

    // Render the HTML as PDF
    $dompdf->render();

    // Get the PDF content
    $pdfContent = $dompdf->output();

    // Create a response object with the PDF content
    $response = new Response($pdfContent);

    // Set headers for attachment and file name
    $response->headers->set('Content-Type', 'application/pdf');
    $response->headers->set('Content-Disposition', 'attachment; filename="expenses.pdf"');

    return $response;
}

}
