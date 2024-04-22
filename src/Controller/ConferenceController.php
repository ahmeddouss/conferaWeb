<?php

namespace App\Controller;

use App\Entity\Conference;
use App\Form\ConferenceType;
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

    return $this->render('conference/index.html.twig', [
        'conferences' => $conferences,
        'searchQuery' => $searchQuery,
        'sortBy' => $sortBy,
        'sortOrder' => $sortOrder,
    ]);
    }
    
    #[Route('/front', name: 'app_conference_front', methods: ['GET'])]
    public function front(ConferenceRepository $conferenceRepository): Response
    {
        return $this->render('conference/front.html.twig', [
            'conferences' => $conferenceRepository->findAll(),
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

}
