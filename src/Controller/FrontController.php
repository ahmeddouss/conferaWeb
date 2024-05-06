<?php

namespace App\Controller;

use App\Repository\ConferenceRepository;
use App\Repository\EmplacementRepository;
use App\Repository\SessionRepository;
use App\Repository\SponsorRepository;
use App\Repository\TopicsRepository;
use App\Repository\UidcardRepository;
use App\Repository\UserRepository;
use App\Service\OpenWeatherMapService;
use App\Service\WeatherService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/frontt')]
class FrontController extends AbstractController
{
    #[Route('/', name: 'app_conference_front', methods: ['GET'])]
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

    #[Route('/{id}', name: 'app_front_show', methods: ['GET'])]
    public function showFront(SessionRepository $sessionRepository, TopicsRepository $topicsRepository,SponsorRepository $sponsorRepository): Response
    {
        $topics = $topicsRepository->findByExampleField(1);

        return $this->render('session/front.html.twig', [
            'sessions' => $sessionRepository->findAll(),
            'topics' => $topics,
            'allTopics' => $topicsRepository->findAll(),
            'sponsors' => $sponsorRepository->findAll(),
        ]);
    }




    #[Route('/presence', name: 'app_front_presence', methods: ['GET'])]
    public function showPresence(OpenWeatherMapService $openWeatherMapService, WeatherService $weatherService, UserRepository $userRepository, TopicsRepository $topicsRepository, EmplacementRepository $emplacementRepository,  SessionRepository $sessionRepository, UidcardRepository $uidcardRepository, ConferenceRepository $conferenceRepository): Response
    {

        $conference= $conferenceRepository->findOneConferenceForToday();
        $place = $conference->getEmplacement();
        $session =  $sessionRepository->findCurrentSession($conferenceRepository);

        $participant= $uidcardRepository->getUniqueParticipantsBySession($session->getId());
        $participant=$userRepository->getUsersByIds($participant);
        $topics = $topicsRepository->findByExampleField($session->getId());

        $weather =$weatherService->getWeather( $openWeatherMapService->getCityGeoInfo($place->getGouvernourat()));

        return $this->render('uidcard/front.html.twig', [
            'session' => $session,
            'uidcards' => $uidcardRepository->findAll(),
            'participant' => $participant,
            'topics' => $topics,
            'sessions' => $sessionRepository->findAll(),
            'allTopics'=> $topicsRepository->findAll(),
            'place' => $place,
            'weather' => $weather,
            'conference' =>$conferenceRepository->findOneConferenceForToday()
        ]);
    }
    #[Route('topic/{id}', name: 'app_front_show_by_id', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function showFrontById(int $id, SessionRepository $sessionRepository, TopicsRepository $topicsRepository): Response
    {
        $topics = $topicsRepository->findByExampleField($id);

        return $this->render('session/front.html.twig', [
            'sessions' => $sessionRepository->findAll(),
            'allTopics'=> $topicsRepository->findAll(),
            'topics' => $topics,
        ]);
    }


}
