<?php

namespace App\Controller;

use App\Entity\Conference;
use App\Form\ConferenceType;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use App\Repository\ConferenceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;


#[Route('/conference')]
class ConferenceController extends AbstractController
{
    #[Route('/', name: 'app_conference_index', methods: ['GET'])]
    public function index(Request $request, ConferenceRepository $conferenceRepository, PaginatorInterface $paginator): Response
    {   
        
        $searchQuery = $request->query->get('q');
        $sortBy = $request->query->get('sortBy', 'nom'); // Default sort by name
        $sortOrder = $request->query->get('sortOrder', 'asc'); // Default sort order is ascending
    
        // Get query for all conferences or search by query
        $query = $conferenceRepository->searchAndSortQuery($searchQuery, $sortBy, $sortOrder);
        
        // Paginate the query
        $conferences = $paginator->paginate(
            $query, // Query to paginate
            $request->query->getInt('page', 1), // Get page number from the request, default to 1
            4 // Number of items per page
        );
        $pageCount = $conferences->getPageCount();
            
        // Get the current page number
        $currentPage = $conferences->getCurrentPageNumber();

        // Calculate startPage and endPage based on the pagination
        $startPage = max(1, $currentPage - 2);
        $endPage = min($pageCount, $currentPage + 2);

        // Calculate pagesInRange array
        $pagesInRange = range($startPage, $endPage);

                // Get the route name for pagination
        $route = 'app_emplacement_index';
        // Define the name of the query parameter for the page number
        $pageParameterName = 'page';

    return $this->render('conference/index.html.twig', [
        'pageParameterName' => $pageParameterName, 
        'route' => $route, // Pass route name to the template
        'pageCount' => $pageCount,
        'startPage' => $startPage,
        'endPage' => $endPage,
        'pagesInRange' => $pagesInRange,
        'current' => $currentPage, // Pass current page number to the template
        'conferences' => $conferences,
        'searchQuery' => $searchQuery,
        'sortBy' => $sortBy,
        'sortOrder' => $sortOrder,

    ]);
    }
    
    #[Route('/front', name: 'app_conference_front', methods: ['GET'])]
    public function front(ConferenceRepository $conferenceRepository): Response
    {
        $conferecesCalendar = [];
        $confereces = $conferenceRepository->findAll();
        foreach ($confereces as $conferece) {
            $conferecesCalendar[] = [
                'id' => $conferece->getId(),
                'start' => $conferece->getDate()->format('Y-m-d H:i:s'),
                'title' => $conferece->getNom(),
                'description' => $conferece->getSujet(),
                // Add other fields as needed
            ];
        }

        $data = json_encode($conferecesCalendar);
        return $this->render('conference/front.html.twig', [
            'conferences' => $conferenceRepository->findAll(),
            'data' => $data
        ]);
    }

    #[Route('/new', name: 'app_conference_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, ParameterBagInterface $parameterBag): Response

    {
        $conference = new Conference();
        $form = $this->createForm(ConferenceType::class, $conference);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if($photo = $form['photo']->getData()){
                $photoDir = $parameterBag->get('photo_dir');
                $fileName = uniqid().'.'.$photo->guessExtension();
                $photo->move($photoDir, $fileName);
                $conference->setImage($fileName);
                
            }
            
            $entityManager->persist($conference);

            $entityManager->flush();

            return $this->redirectToRoute('app_conference_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('conference/new.html.twig', [
            'conference' => $conference,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_conference_show', methods: ['GET'])]
    public function show(Conference $conference): Response
    {
        return $this->render('conference/show.html.twig', [
            'conference' => $conference,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_conference_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Conference $conference, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ConferenceType::class, $conference);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $entityManager->flush();

            return $this->redirectToRoute('app_conference_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('conference/edit.html.twig', [
            'conference' => $conference,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_conference_delete', methods: ['POST'])]
    public function delete(Request $request, Conference $conference, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$conference->getId(), $request->request->get('_token'))) {
            $entityManager->remove($conference);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_conference_index', [], Response::HTTP_SEE_OTHER);
    }
   
    #[Route('/generate-qrcode/{id}', name: 'generate_qr_code')]
    public function generateQRCode($id, EntityManagerInterface $entityManagerInterface): Response
    {
        $conference = $entityManagerInterface->getRepository(Conference::class)->findOneBy(['id' => $id]);
    
        // Check if reservation is not found
        if (!$conference) {
            // Throw a more descriptive exception with the actual ID value
            throw $this->createNotFoundException('Conference not found for ID: ' . $id);
        }

        // Generate QR code content (You can customize this according to your requirements)
        $qrCodeContent = 'Conference Name: ' . $conference->getNom() . "\n". "\n";
        $qrCodeContent .= 'Conference Description: ' . $conference->getSujet(). "\n". "\n";
        $qrCodeContent .= ' At: ' . $conference->getDate()->format('Y-m-d') . "\n". "\n";
        $qrCodeContent .= 'Goverment: ' . ($conference->getEmplacement()->getGouvernourat()) . "\n";
        $qrCodeContent .= 'City: ' . ($conference->getEmplacement()->getVille()) . "\n";
        $qrCodeContent .= 'Label: ' . ($conference->getEmplacement()->getLabel()) . "\n";
    
        // Generate QR code
        $qrCode = Builder::create()
            ->writerOptions(['exclude_xml_declaration' => true])
            ->writer(new PngWriter())
            ->data($qrCodeContent)
            ->backgroundColor(new Color(0, 175, 255))
            ->foregroundColor(new Color(73, 0, 9))
            ->size(300)
            ->labelText("Confera")
            ->margin(10)
            ->build();
    
        // Return QR code as response
        return new Response($qrCode->getString(), Response::HTTP_OK, [
            'Content-Type' => $qrCode->getMimeType(),
        ]);
    }

}
