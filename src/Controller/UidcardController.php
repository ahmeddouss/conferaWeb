<?php

namespace App\Controller;

use App\Entity\Uidcard;
use App\Form\UidcardType;
use App\Repository\ConferenceRepository;
use App\Repository\EmplacementRepository;
use App\Repository\SessionRepository;
use App\Repository\UidcardRepository;
use App\Repository\UserRepository;
use App\Service\CardService;
use App\Service\MachineLearningService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/uidcard')]
class UidcardController extends AbstractController
{
    #[Route('/', name: 'app_uidcard_index', methods: ['GET'])]
    public function index(UidcardRepository $uidcardRepository,UserRepository $userRepository ,FlashyNotifier $flashy): Response
    {

        return $this->render('uidcard/index.html.twig', [
            'users' => $userRepository->findAll(),
            'uidcards' => $uidcardRepository->findAll()


        ]);
    }





    #[Route('/live', name: 'app_uidcard_live')]
    public function live(ConferenceRepository $conferenceRepository, SessionRepository $sessionRepository,EmplacementRepository $emplacementRepository): Response
    {
        $session=null;
        $place=null;
        $conference=null;

        $conference = $conferenceRepository->findOneConferenceForToday();
            if ($conference != null){
                $place = $conference->getEmplacement();
                $session = $sessionRepository->findCurrentSession($conferenceRepository);
            }



        return $this->render('uidcard/live.html.twig', [
            'conference' => $conference,
            'session' => $session,
            'place' => $place,
        ]);
    }
    #[Route('/ai/test/yes/', name: 'app_uidcard_ai', methods: ['GET'])]
    public function tester(MachineLearningService $machineLearningService,EntityManagerInterface $entityManager ,UidcardRepository $uidcardRepository,SessionRepository $sessionRepository,ConferenceRepository $conferenceRepository): Response
    {



            $session = $sessionRepository->findCurrentSession($conferenceRepository);



                //get time spent quality
                $uidCardInThisSession=$uidcardRepository->getBySession($session->getId());
                $diffTime=[3,3,3];
                foreach ($uidCardInThisSession as $uidCard) {
                    if ($uidCard->getStatus()!=0 && $uidCard->getStatus() %2 ==0 ){

                        $endTime    = $uidCard->getCurrenttime();
                        $endMinute = $endTime->format('H') * 60 . $endTime->format('i');


                        //maybe not id just getidpart
                        try {
                            $startTime = $uidcardRepository->getOutUid($uidCard->getIdparticipant()->getId())->getCurrenttime();
                            $startMinute = $startTime->format('H') * 60 . $startTime->format('i');

                            $diffTime[] = $endMinute - $startMinute;

                        } catch (NonUniqueResultException $e) {
                        }

                    }
                }

                echo "This is the array diffTime: ";
                print_r($diffTime);
                $qualityVal= $machineLearningService->getAiValueStability($diffTime);
        $session->setPresencequality($qualityVal);




        //increment presence nbr
        $oldPresenceNbr = $session->getPresencenbr();
        $session->setPresencenbr($oldPresenceNbr+1);

        //save changes
        $entityManager->persist($session);
        $entityManager->flush();



            return $this->render('uidcard/test.html.twig', [
            'response' => $qualityVal,

        ]);
    }

    #[Route('/push/{uid}', name: 'push')]
    public function publish(MachineLearningService $machineLearningService ,HubInterface $hub,CardService $cardService, string $uid,UidcardRepository $uidcardRepository,EntityManagerInterface $entityManager,SessionRepository $sessionRepository,ConferenceRepository $conferenceRepository): Response
    {
        //get uidcard from api service
        //$uid= $cardService->addCardUid();
        $username="none";
        $minutes=0;
        //verif if the uid card new
        $uidcard = new Uidcard();
        //if card exist
        $time = new \DateTime();

        if(!$cardService->verifNewCard($uid,$entityManager)){
            $lastcard= $uidcardRepository->findByUidWithMaxStatus($uid);
            $status=$lastcard->getStatus();
            $session = $sessionRepository->findCurrentSession($conferenceRepository);

            $uidCard = new Uidcard();
            $uidCard->setUid($uid);

            $uidCard->setCurrenttime(new \DateTime());
            $uidCard->setStatus($status+1);
            $uidCard->setIdSession($session->getId());
            $uidCard->setIdparticipant($lastcard->getIdparticipant());
        $username=$lastcard->getIdparticipant()->getUsername();
            $entityManager->persist($uidCard);
            $entityManager->flush();

            //if in if out
            if($status % 2 === 0){
                $status="in";
            }else{
                $status="out";
                //get time spent
                $newPresenceSpent = $lastcard->getCurrenttime()->diff($time);
                $minutes = $newPresenceSpent->h * 60; // Total minutes from hours
                $minutes += $newPresenceSpent->i; // Minutes


                //get time spent quality
                $uidCardInThisSession=$uidcardRepository->getBySession($session->getId());
                $diffTime=[];
                foreach ($uidCardInThisSession as $CurrentUidCard) {
                    if ($CurrentUidCard->getStatus()!=0 && $CurrentUidCard->getStatus() %2 ==0 ){

                        $endTime    = $CurrentUidCard->getCurrenttime();
                        $endMinute = $endTime->format('H') * 60 . $endTime->format('i');


                        //maybe not id just getidpart
                        try {
                            $startTime = $uidcardRepository->getOutUid($CurrentUidCard->getIdparticipant()->getId())->getCurrenttime();
                            $startMinute = $startTime->format('H') * 60 . $startTime->format('i');

                            $diffTime[] = $endMinute - $startMinute;

                        } catch (NonUniqueResultException $e) {
                        }

                    }
                }

                //increment quality
                $qualityVal= $machineLearningService->getAiValueStability($diffTime);
                echo $qualityVal;

                print_r($diffTime);

                $session->setPresencequality($qualityVal);

                //increment presence spent
                $oldPresenceSpent = $session->getPresencespent();
                $session->setPresencespent($oldPresenceSpent+$minutes);

                //increment presence nbr
                $oldPresenceNbr = $session->getPresencenbr();
                $session->setPresencenbr($oldPresenceNbr+1);

                //save changes
                $entityManager->persist($session);
                $entityManager->flush();
            }


        }else{
            $status="new";
        }

        $time = $time->format('h:i A');

        $update = new Update(
            'http://192.168.1.13/rfid',
            json_encode(['status' => $status,'time'=>$time,'username'=>$username,'timeSpent'=>$minutes])
        );


        $hub->publish($update);

        return new Response('published!');
    }
    #[Route('/new', name: 'app_uidcard_new', methods: ['GET', 'POST'])]
    public function addCard(UidcardRepository $uidcardRepository,UserRepository $userRepository, CardService $cardService,Request $request, EntityManagerInterface $entityManager): Response
    {


        $uid= $cardService->addCardUid();
        $uidcard = new Uidcard();

        if($cardService->verifNewCard($uid,$entityManager)){


            $uidcard->setUid($uid);
            $uidcard->setCurrenttime(new \DateTime());
            $uidcard->setStatus(0);

            $form = $this->createForm(UidcardType::class, $uidcard);
            $form->handleRequest($request);




        }else{
            $errorMessage = 'Please Verify that you passed new card'; // Replace with your custom error message
            $uidcard->setUid("");
            $form = $this->createForm(UidcardType::class, $uidcard);
            $form->handleRequest($request);
            $form->get('uid')->addError(new FormError($errorMessage));
        }


        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($uidcard);
            $entityManager->flush();

            return $this->redirectToRoute('app_uidcard_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('uidcard/new.html.twig', [
            'uidcard' => $uidcard,
            'form' => $form,
            'users' => $userRepository->findAll(),
            'uidcards' => $uidcardRepository->findAll()

        ]);
    }
    #[Route( '/{username}',name: 'app_uidcard_flashy', methods: ['GET'])]
    public function flashy(string $username, UidcardRepository $uidcardRepository,UserRepository $userRepository ,FlashyNotifier $flashy): Response
    {

        if (str_ends_with($username, "in")) {
            $flashy->success($username);
        }else{
            $flashy->error($username);
        }

        return $this->render('uidcard/index.html.twig', [
            'users' => $userRepository->findAll(),
            'uidcards' => $uidcardRepository->findAll()


        ]);
    }




    #[Route('/delete/{uid}', name: 'app_uidcard_delete', methods: ['POST'])]
    public function deleteAll(Request $request, string $uid, UidcardRepository $uidcardRepository, EntityManagerInterface $entityManager): Response
    {
        // Find all Uidcard entities with the specified UID
        $uidcards = $uidcardRepository->findBy(['uid' => $uid]);

        if (!$uidcards) {
            throw $this->createNotFoundException('Uidcards not found for the given UID');
        }

        foreach ($uidcards as $uidcard) {
            $entityManager->remove($uidcard);
        }

        $entityManager->flush();

        return $this->redirectToRoute('app_uidcard_index', [], Response::HTTP_SEE_OTHER);
    }



}
