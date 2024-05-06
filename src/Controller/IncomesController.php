<?php

namespace App\Controller;

use App\Entity\Incomes;
use App\Form\IncomesType;
use App\Repository\IncomesRepository;
use App\Repository\ExpensesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use Symfony\Component\HttpFoundation\ResponseHeaderBag;

use Dompdf\Dompdf;
use Dompdf\Options;


#[Route('/incomes')]
class IncomesController extends AbstractController
{
#[Route('/', name: 'app_incomes_index', methods: ['GET'])]
public function index(IncomesRepository $incomesRepository): Response
{
    $incomes = $incomesRepository->findAll();

    // Prepare data for Chart.js
    $labels = [];
    $data = [];

    foreach ($incomes as $income) {
        $labels[] = $income->getFromwhat();
        $data[] = $income->getIncammount();
    }

    // Convert data to JSON format
    $chartData = [
        'labels' => $labels,
        'data' => $data,
    ];

    // Render the template with the data
    return $this->render('incomes/index.html.twig', [
        'chartData' => json_encode($chartData), // Pass the chart data to the Twig template
        'incomes' => $incomes,
    ]);
}


#[Route('/dash', name: 'app_dash_index', methods: ['GET'])]
public function dash(
    IncomesRepository $incomesRepository,
    ExpensesRepository $expensesRepository
): Response {
    $incomes = $incomesRepository->findAll();

    $totalIncome = 0;
    $totalExpenses = 0;

    foreach ($incomes as $income) {
        $totalIncome += $income->getIncammount();
    }

    $expenses = $expensesRepository->findAll();
    foreach ($expenses as $expense) {
        $totalExpenses += $expense->getExpammount();
    }

    return $this->render('dash/index.html.twig', [
        'totalIncomes' => $totalIncome,
        'totalExpenses' => $totalExpenses,
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

    #[Route('/export/pdf', name: 'app_incomes_export_pdf', methods: ['GET'])]
public function exportPdf(IncomesRepository $incomesRepository): Response
{
    $incomes = $incomesRepository->findAll();

    $html = $this->renderView('incomes/pdf.html.twig', [
        'incomes' => $incomes,
    ]);

    // Configure Dompdf options
    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);

    // Instantiate Dompdf with our options
    $dompdf = new Dompdf($options);

    // Load HTML content
    $dompdf->loadHtml($html);

    // (Optional) Set the paper size and orientation
    $dompdf->setPaper('A4', 'landscape');

    // Render the HTML as PDF
    $dompdf->render();

    // Get the PDF content
    $pdfContent = $dompdf->output();

    // Create a response object with the PDF content
    $response = new Response($pdfContent);

    // Set headers for attachment and file name
    $response->headers->set('Content-Type', 'application/pdf');
    $response->headers->set('Content-Disposition', 'attachment; filename="incomes.pdf"');

    return $response;
}
}


