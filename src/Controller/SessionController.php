<?php

namespace App\Controller;

use App\Entity\Session;
use App\Form\SessionType;
use App\Repository\ConferenceRepository;
use App\Repository\SessionRepository;
use App\Repository\SponsorRepository;
use App\Repository\TopicsRepository;
use App\Repository\UidcardRepository;
use App\Repository\UserRepository;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\ColumnChart;

use Doctrine\ORM\EntityManagerInterface;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/session')]
class SessionController extends AbstractController
{
    #[Route('/', name: 'app_session_index', methods: ['GET'])]
    public function index(SessionRepository $sessionRepository): Response
    {
        return $this->render('session/index.html.twig', [
            'sessions' => $sessionRepository->findAll(),
        ]);
    }

    #[Route('/conf', name: 'confer', methods: ['GET'])]
    public function conf(ConferenceRepository $conferenceRepository,SessionRepository $sessionRepository): Response
    {


        $test2=$sessionRepository->findCurrentSession($conferenceRepository)->getSessionname();
        return new Response($test2);
    }







    #[Route('/chart', name: 'app_session_chart', methods: ['GET'])]
    public function chart(SessionRepository $sessionRepository): Response
    {


        $colors = ["#EC565C","#013766","#00AFFF"];
        $columnChart = new ColumnChart();
        $sessions = $sessionRepository->findAll();
        $chartData = [
            ['', 'Considerable', 'Non Considerable', 'Session Duration'],
        ];

        foreach ($sessions as $session) {
            $sessionName = $session->getSessionname();
            $startTime = $session->getStarttime();
            $endTime = $session->getEndtime();
            $diffInSeconds = $endTime->getTimestamp() - $startTime->getTimestamp();

            if($session->getPresencenbr()==0){
                $moyTimeSpent=0;

            }else{
                $moyTimeSpent = $session->getPresencespent()/$session->getPresencenbr();
            }

            $sessionDurationMinutes = round($diffInSeconds / 60);
            if ($session->getPresencequality()==0){
                // Assuming you want to populate 'Session Duration' column with the calculated duration
                $chartData[] = [$sessionName, $moyTimeSpent, 0, $sessionDurationMinutes-$moyTimeSpent];
            }else{
                $chartData[] = [$sessionName,0 , $moyTimeSpent, $sessionDurationMinutes-$moyTimeSpent];
            }

        }

        $columnChart->getData()->setArrayToDataTable($chartData);


        $columnChart->getOptions()->setHeight(400);
        $columnChart->getOptions()->setWidth(800);
        $columnChart->getOptions()->getBar()->setGroupWidth('40%');
        $columnChart->getOptions()->setIsStacked(true);

        $columnChart->getOptions()->setFontName("SF Pro Display");
        $columnChart->getOptions()->setColors($colors);




        return $this->render('session/chart.html.twig', [
            'sessions' => $sessionRepository->findAll(),
            'columnChart' => $columnChart
        ]);
    }



    #[Route('/chart/{id}/', name: 'app_presence_chart', methods: ['GET'])]
    public function presence(int $id,UserRepository $userRepository,UidcardRepository $uidcardRepository,SessionRepository $sessionRepository): Response
    {

        $colors = ["#EC565C","#013766","#00AFFF"];
        $columnChart = new ColumnChart();
        $sessions = $sessionRepository->findAll();
        $sessionz = $sessions[$id];
        $chartData = [
            ['', 'Considerable', 'Non Considerable', 'Session Duration'],
        ];

        foreach ($sessions as $session) {
            $sessionName = $session->getSessionname();
            $startTime = $session->getStarttime();
            $endTime = $session->getEndtime();
            $diffInSeconds = $endTime->getTimestamp() - $startTime->getTimestamp();
            if($session->getPresencenbr()==0){
                $moyTimeSpent=0;

            }else{
                $moyTimeSpent = $session->getPresencespent()/$session->getPresencenbr();
            }

            $sessionDurationMinutes = round($diffInSeconds / 60);
            if ($session->getPresencequality()==0){
                // Assuming you want to populate 'Session Duration' column with the calculated duration
                $chartData[] = [$sessionName, $moyTimeSpent, 0, $sessionDurationMinutes-$moyTimeSpent];
            }else{
                $chartData[] = [$sessionName,0 , $moyTimeSpent, $sessionDurationMinutes-$moyTimeSpent];
            }

        }

        $columnChart->getData()->setArrayToDataTable($chartData);


        $columnChart->getOptions()->setHeight(400);
        $columnChart->getOptions()->setWidth(800);
        $columnChart->getOptions()->getBar()->setGroupWidth('40%');
        $columnChart->getOptions()->setIsStacked(true);

        $columnChart->getOptions()->setFontName("SF Pro Display");
        $columnChart->getOptions()->setColors($colors);




        return $this->render('uidcard/presence.html.twig', [
            'users' => $userRepository->findAll(),
            'uidcards' => $uidcardRepository->findAll(),
            'sessions' => $sessionRepository->findAll(),
            'columnChart' => $columnChart,
            'session' => $sessionz

        ]);
    }
    #[Route( '/chart/{id}/{username}',name: 'app_chart_flashy', methods: ['GET'])]
    public function flashy(int $id,SessionRepository $sessionRepository,string $username, UidcardRepository $uidcardRepository,UserRepository $userRepository ,FlashyNotifier $flashy): Response
    {

        if (str_ends_with($username, "in")) {
            $flashy->success($username);
        }else{
            $flashy->error($username);
        }

        $colors = ["#EC565C","#013766","#00AFFF"];
        $columnChart = new ColumnChart();
        $sessions = $sessionRepository->findAll();
        $sessionz = $sessions[$id];
        $chartData = [
            ['', 'Considerable', 'Non Considerable', 'Session Duration'],
        ];

        foreach ($sessions as $session) {
            $sessionName = $session->getSessionname();
            $startTime = $session->getStarttime();
            $endTime = $session->getEndtime();
            $diffInSeconds = $endTime->getTimestamp() - $startTime->getTimestamp();
            if($session->getPresencenbr()==0){
                $moyTimeSpent=0;

            }else{
                $moyTimeSpent = $session->getPresencespent()/$session->getPresencenbr();
            }

            $sessionDurationMinutes = round($diffInSeconds / 60);
            if ($session->getPresencequality()==0){
                // Assuming you want to populate 'Session Duration' column with the calculated duration
                $chartData[] = [$sessionName, $moyTimeSpent, 0, $sessionDurationMinutes-$moyTimeSpent];
            }else{
                $chartData[] = [$sessionName,0 , $moyTimeSpent, $sessionDurationMinutes-$moyTimeSpent];
            }

        }

        $columnChart->getData()->setArrayToDataTable($chartData);


        $columnChart->getOptions()->setHeight(400);
        $columnChart->getOptions()->setWidth(800);
        $columnChart->getOptions()->getBar()->setGroupWidth('40%');
        $columnChart->getOptions()->setIsStacked(true);

        $columnChart->getOptions()->setFontName("SF Pro Display");
        $columnChart->getOptions()->setColors($colors);


        return $this->render('uidcard/presence.html.twig', [
            'users' => $userRepository->findAll(),
            'uidcards' => $uidcardRepository->findAll(),
            'sessions' => $sessionRepository->findAll(),
            'columnChart' => $columnChart,
            'session' => $sessionz


        ]);
    }

    #[Route('/new', name: 'app_session_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $session = new Session();
        $form = $this->createForm(SessionType::class, $session);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($session);
            $entityManager->flush();

            return $this->redirectToRoute('app_session_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('session/new.html.twig', [
            'session' => $session,
            'form' => $form,
        ]);
    }


    #[Route('/{id}', name: 'app_session_show', methods: ['GET'])]
    public function show(int $id, SessionRepository $sessionRepository, TopicsRepository $topicsRepository): Response
    {
        $session = $sessionRepository->find($id); // Fetch the session entity by ID
        if (!$session) {
            throw $this->createNotFoundException('Session not found');
        }

        $topics = $topicsRepository->findByExampleField($id); // Assuming findByExampleField is a custom method in your TopicsRepository

        return $this->render('session/show.html.twig', [
            'session' => $session,
            'topics' => $topics,
        ]);
    }




    #[Route('/{id}/edit', name: 'app_session_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Session $session, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SessionType::class, $session);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->flush();

            return $this->redirectToRoute('app_session_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('session/edit.html.twig', [
            'session' => $session,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_session_delete', methods: ['POST'])]
    public function delete(Request $request, Session $session, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$session->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($session);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_session_index', [], Response::HTTP_SEE_OTHER);
    }


}
