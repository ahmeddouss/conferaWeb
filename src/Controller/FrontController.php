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


    #[Route('/', name: 'app_conference_front', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function front(OpenWeatherMapService $openWeatherMapService, WeatherService $weatherService, UserRepository $userRepository,ConferenceRepository $conferenceRepository, UidcardRepository $uidcardRepository, SponsorRepository $sponsorRepository, SessionRepository $sessionRepository, TopicsRepository $topicsRepository): Response
    {   $participant=null;
        $session=null;
        $topics=null;
        $weather=null;
        $place=null;

        $conference= $conferenceRepository->findOneConferenceForToday();
        if($conference){
            $place = $conference->getEmplacement();
            $session =  $sessionRepository->findCurrentSession($conferenceRepository);
            $weather =$weatherService->getWeather( $openWeatherMapService->getCityGeoInfo($place->getGouvernourat()));

        }

        if ($session){
            $participant= $uidcardRepository->getUniqueParticipantsBySession($session->getId());
            $participant=$userRepository->getUsersByIds($participant);
            $topics = $topicsRepository->findByExampleField($session->getId());
        }


        $sponsors = $sponsorRepository->findAll();
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

        $allSession=$sessionRepository->findAll();
        $topics = $topicsRepository->findByExampleField($allSession[0]->getId());

        return $this->render('session/front.html.twig', [
            'sessions' => $sessionRepository->findAll(),
            'allTopics'=> $topicsRepository->findAll(),
            'topics' => $topics,
            'conferences' => $conferenceRepository->findAll(),
            'data' => $data,
            'sponsors' => $sponsors,
            'place' => $place,
            'weather' => $weather,
            'conference' =>$conferenceRepository->findOneConferenceForToday(),
            'session' => $session,
            'participant' => $participant,
            'uidcards' => $uidcardRepository->findAll(),
        ]);
    }

    #[Route('conference/{id}', name: 'app_front_show_sess', methods: ['GET'])]
    public function showFrontSession(ConferenceRepository $conferenceRepository,int $id,SessionRepository $sessionRepository, TopicsRepository $topicsRepository,SponsorRepository $sponsorRepository): Response
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
        $sessions=$sessionRepository->findByIdConf($id);
        $topics = $topicsRepository->findBySessionId($sessions[0]->getId());

        return $this->render('session/front.html.twig', [
            'conferences' => $conferenceRepository->findAll(),
            'data' => $data,
            'sessions' => $sessions,
            'topics' => $topics,
            'allTopics' => $topicsRepository->findAll(),
            'sponsors' => $sponsorRepository->findAll(),
        ]);
    }

    #[Route('/session/{id}', name: 'app_front_show_topic', methods: ['GET'])]
    public function showFrontTopic(ConferenceRepository $conferenceRepository,int $id,SessionRepository $sessionRepository, TopicsRepository $topicsRepository,SponsorRepository $sponsorRepository): Response
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
        $sessions=$sessionRepository->findByIdConf($id);
        $topics = $topicsRepository->findBySessionId($sessions[0]->getId());

        return $this->render('session/front.html.twig', [
            'conferences' => $conferenceRepository->findAll(),
            'data' => $data,
            'sessions' => $sessions,
            'topics' => $topics,
            'allTopics' => $topicsRepository->findAll(),
            'sponsors' => $sponsorRepository->findAll(),
        ]);
    }




    #[Route('/presence', name: 'app_front_presence', methods: ['GET'])]
    public function showPresence(OpenWeatherMapService $openWeatherMapService, WeatherService $weatherService, UserRepository $userRepository, TopicsRepository $topicsRepository, EmplacementRepository $emplacementRepository,  SessionRepository $sessionRepository, UidcardRepository $uidcardRepository, ConferenceRepository $conferenceRepository): Response
    {
        $participant=null;
        $session=null;
        $topics=null;
        $weather=null;
        $place=null;

        $conference= $conferenceRepository->findOneConferenceForToday();
        if($conference){
            $place = $conference->getEmplacement();
            $session =  $sessionRepository->findCurrentSession($conferenceRepository);
            $weather =$weatherService->getWeather( $openWeatherMapService->getCityGeoInfo($place->getGouvernourat()));

        }

        if ($session){
            $participant= $uidcardRepository->getUniqueParticipantsBySession($session->getId());
            $participant=$userRepository->getUsersByIds($participant);
            $topics = $topicsRepository->findByExampleField($session->getId());
        }




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
    #[Route('/topic/{id}', name: 'app_front_show_by_id', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function showFrontById(int $id,OpenWeatherMapService $openWeatherMapService, WeatherService $weatherService, UserRepository $userRepository,ConferenceRepository $conferenceRepository, UidcardRepository $uidcardRepository, SponsorRepository $sponsorRepository, SessionRepository $sessionRepository, TopicsRepository $topicsRepository): Response
    {   $participant=null;
        $session=null;
        $topics=null;
        $weather=null;
        $place=null;

        $conference= $conferenceRepository->findOneConferenceForToday();
        if($conference){
            $place = $conference->getEmplacement();
            $session =  $sessionRepository->findCurrentSession($conferenceRepository);
            $weather =$weatherService->getWeather( $openWeatherMapService->getCityGeoInfo($place->getGouvernourat()));

        }

        if ($session){
            $participant= $uidcardRepository->getUniqueParticipantsBySession($session->getId());
            $participant=$userRepository->getUsersByIds($participant);
            $topics = $topicsRepository->findByExampleField($session->getId());
        }


        $sponsors = $sponsorRepository->findAll();
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


        $topics = $topicsRepository->findByExampleField($id);

        return $this->render('session/front.html.twig', [
            'sessions' => $sessionRepository->findAll(),
            'allTopics'=> $topicsRepository->findAll(),
            'topics' => $topics,
            'conferences' => $conferenceRepository->findAll(),
            'data' => $data,
            'sponsors' => $sponsors,
            'place' => $place,
            'weather' => $weather,
            'conference' =>$conferenceRepository->findOneConferenceForToday(),
            'session' => $session,
            'participant' => $participant,
            'uidcards' => $uidcardRepository->findAll(),
        ]);
    }


}
