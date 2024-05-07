<?php

namespace App\Controller;

use App\Entity\Sponsor;
use App\Form\SponsorType;
use App\Repository\SponsorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Knp\Component\Pager\PaginatorInterface;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use App\Service\PdfGeneratorService;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

#[Route('/sponsor')]

class SponsorController extends AbstractController
{
    #[Route('/', name: 'app_sponsor_index', methods: ['GET'])]
    public function index(Request $request, SponsorRepository $sponsorRepository, PaginatorInterface $paginator): Response
    {
        // Filter sponsors based on the selected status
        $status = $request->query->get('status');
        $queryBuilder = $sponsorRepository->createQueryBuilder('s'); // Create a query builder for the Sponsor entity
        if ($status === 'accepted') {
            $queryBuilder->andWhere('s.status = :status')->setParameter('status', 'accepted');
        } elseif ($status === 'rejected') {
            $queryBuilder->andWhere('s.status = :status')->setParameter('status', 'rejected');
        }

        // Get the search query from the request and filter sponsors based on it
        $searchQuery = $request->query->get('query');
        if ($searchQuery) {
            $queryBuilder
                ->andWhere('s.nom LIKE :searchQuery')
                ->setParameter('searchQuery', '%' . $searchQuery . '%');
        }

        $query = $queryBuilder->getQuery();

        // Get pagination for the filtered sponsors
        $pagination = $paginator->paginate(
            $query, // Query results
            $request->query->getInt('page', 1), // Current page number
            2 // Number of items per page
        );

        // Count accepted and rejected sponsors
        $acceptedSponsorsCount = $sponsorRepository->count(['status' => 'accepted']);
        $rejectedSponsorsCount = $sponsorRepository->count(['status' => 'rejected']);

        // Calculate the sum of the budget field for accepted sponsors


        $acceptedSponsorsBudgetSum = $sponsorRepository->countBygetAcceptedSponsorsBudgetSum();
        // Call the custom repository method to get the sum of the budget field for accepted sponsors

        return $this->render('sponsor/index.html.twig', [
            'pagination' => $pagination,
            'acceptedSponsorsCount' => $acceptedSponsorsCount,
            'rejectedSponsorsCount' => $rejectedSponsorsCount,
            'acceptedSponsorsBudgetSum' => $acceptedSponsorsBudgetSum,
        ]);
    }

    #[Route('/share/facebook', name: 'app_sponsor_share_on_facebook', methods: ['GET'])]
    public function shareOnFacebook(Request $request, SponsorRepository $sponsorRepository): RedirectResponse
    {
        $sponsorId = $request->query->get('id');
        $sponsor = $sponsorRepository->find($sponsorId);

        if (!$sponsor) {
            throw $this->createNotFoundException('Sponsor not found');
        }

        $name = $sponsor->getNom();
        $email = $sponsor->getEmail();

        // Construct the edit route URL for the sponsor
        $editRouteUrl = $this->generateUrl('app_sponsor_edit', ['id' => $sponsorId], UrlGeneratorInterface::ABSOLUTE_URL);

        // Construct the Facebook sharing URL with email, name, and edit route parameters
        $facebookSharingUrl = 'https://www.facebook.com/sharer/sharer.php?u=' . urlencode($editRouteUrl) . '&quote=' . urlencode("Check out sponsor $name ($email)!");

        // Redirect to the Facebook sharing URL
        return $this->redirect($facebookSharingUrl);
    }


    #[Route('/new', name: 'app_sponsor_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, PdfGeneratorService $PdfGenerator): Response
    {
        $sponsor = new Sponsor();
        $form = $this->createForm(SponsorType::class, $sponsor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($sponsor);
            $entityManager->flush();

            $pdfContent = $PdfGenerator->generateSponsorPdf($sponsor);

            return new Response(
                $pdfContent,
                200,
                [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'attachment; filename="sponsor_details.pdf"',
                ]
            );


        }

        return $this->render('sponsor/new.html.twig', [
            'sponsor' => $sponsor,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_sponsor_show', methods: ['GET'])]
    public function show(Sponsor $sponsor): Response
    {
        return $this->render('sponsor/show.html.twig', [
            'sponsor' => $sponsor,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_sponsor_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Sponsor $sponsor, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SponsorType::class, $sponsor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_sponsor_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('sponsor/edit.html.twig', [
            'sponsor' => $sponsor,
            'form' => $form,
        ]);
    }



    #[Route('/qrcode/{id}', name: 'qr_code')]
    public function generateQRCode($id, SponsorRepository $sponsorRepository): Response
    {
        // Fetch the Sponsor by ID
        $sponsor = $sponsorRepository->find($id);

        // Check if Sponsor is not found
        if (!$sponsor) {
            // Throw a more descriptive exception with the actual ID value
            throw $this->createNotFoundException('Sponsor not found for ID: ' . $id);
        }

        // Generate QR code content (You can customize this according to your requirements)
        $qrCodeContent = 'Nom: ' . $sponsor->getNom() . "\n";
        $qrCodeContent .= 'NumTel: ' . $sponsor->getNumTel() . "\n";
        $qrCodeContent .= 'Email: ' . $sponsor->getEmail() . "\n";
        $qrCodeContent .= 'Status: ' . $sponsor->getStatus() . "\n";

        // Debug QR code content
        dump($qrCodeContent);

        // Generate QR code
        $qrCode = Builder::create()
            ->writerOptions(['exclude_xml_declaration' => true])
            ->writer(new PngWriter())
            ->data($qrCodeContent)
            ->size(300)
            ->margin(10)
            ->build();

        // Return QR code as response
        return new Response($qrCode->getString(), Response::HTTP_OK, [
            'Content-Type' => $qrCode->getMimeType(),
        ]);
    }


    #[Route('/{id}', name: 'app_sponsor_delete', methods: ['POST'])]
    public function delete(Request $request, Sponsor $sponsor, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sponsor->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($sponsor);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_sponsor_index', [], Response::HTTP_SEE_OTHER);
    }



}
