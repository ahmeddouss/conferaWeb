<?php

namespace App\Controller;

use App\Entity\Uidcard;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Mailtrap\Config;
use Mailtrap\Helper\ResponseHelper;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Ramsey\Uuid\Uuid;
use Mailtrap\MailtrapSandboxClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;


use Endroid\QrCode\Color\Color;


use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;

use Endroid\QrCode\Label\Font\NotoSans;

#[Route('/user')]
class UserController extends AbstractController
{


    #[Route('/', name: 'app_user_index', methods: ['GET'])]
    public function index(MailerInterface $mailer,UserRepository $userRepository): Response
    {

        $title="yes";
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
            'title' => $title
        ]);
    }




    #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(MailerInterface $mailer,User $user, EntityManagerInterface $entityManager,FlashyNotifier $flashy): Response
    {
        //prepare uid
        $uuid = Uuid::uuid4();
        $uuidString = $uuid->toString();

        //save to database

        $uidCard = new Uidcard();
        $uidCard->setUid($uuidString);
        $uidCard->setIdparticipant($user);
        $uidCard->setCurrenttime(new \DateTime());
        $uidCard->setStatus(0);


            $entityManager->persist($uidCard);
            $entityManager->flush();



        //convert to qr
        $writer = new PngWriter();
        $qrLink = "http://192.168.1.16:8000/uidcard/push/" . $uuidString;
        $qrCode = QrCode::create($qrLink)
            ->setEncoding(new Encoding('UTF-8'))

            ->setSize(450)
            ->setMargin(0)
            ->setForegroundColor(new Color(0, 0, 0))
            ->setBackgroundColor(new Color(255, 255, 255));

        $label = Label::create($user->getUsername()."'s Invitation")->setFont(new NotoSans(18));

        $qrCodeImage  = $writer->write(
            $qrCode,
            null,
            $label->setText($user->getUsername()."'s Invitation")
        );
        $test['simple']= $writer->write(
            $qrCode,
            null,
            $label
        );
        $imgSource = $qrCodeImage->getDataUri();
        //send qr email
        $apikey='bf4c10d771055ef3311ee57e4efa3369';
        $mailtrap = new MailtrapSandboxClient(new Config($apikey));
        // Convert QR code image to data URI

// Embed the QR code image into HTML content
        $htmlContent = "
<!DOCTYPE html>
<html lang=\"en\">
<head>
    <meta charset=\"UTF-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <title>Your Title Here</title>
    <style>
        body {
            font-family: 'SF Pro Display', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            font-size: 16px;
            line-height: 1.6;
            color: #333; /* Text color */
            background-color: #f8f9fa; /* Page background color */
            margin: 0;
            padding: 0;
        }
        a {
            color: #007bff; /* Blue link color */
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        p {
            margin: 0;
        }
    </style>
</head>
<body>
    <div style=\"padding: 20px; flex-direction: column; justify-content: center; align-items: center;\">
        <h1 style=\"text-align: center;\">Welcome to Our Sessions!</h1>
     <p style=\"margin: 20px;\">Hello <span style='font-weight: 700;'>".$user->getUsername()."</span></p>

        <div style=\"margin: 20px;\">
            <p>You are invited to join <a href=\"http://127.0.0.1:8000/front/0\">Our Sessions</a></p>
            <p>To be able to access our sessions, you need to  install the QR code invitation.</p>
            <p>Clique Here To <a  href='$imgSource' download=\"Qr_Invitation.png\">Download Invitation.</a> </p> 
            <p>For more information, you can visit our website <a href=\"#http://127.0.0.1::8000/front/0\">here</a> or you can send us an email.</p>
        </div>
       
    <br>
  
   
    
    
        <footer>
            <div style=\"flex-direction: column; display: flex; justify-content: center; top:100%; align-items: center;\">
              <div  style=\"border-radius:20px;background-color:white;padding:10px ;height: 120px;width:120px;box-shadow: 4px 4px 20px -8px rgba(0, 0, 0, 0.25);  border: 1px #B39D9D solid\">
     <img src='$imgSource' style=\"
    width: 120px;
    height: 120px;
\" >
</div>
<br>
                <p>Copyright © 2036 <a href=\"#\">Confera </a>. All rights reserved.</p>
                <p>Design: <a href=\"https://www.figma.com/file/zWIawDW9U7uLPruy57755M/Confera?type=design&node-id=0%3A1&mode=design&t=jPRFimlHmnWyotmg-1\" target=\"_blank\">Ahmed Douss</a></p>
            </div>
        </footer>
    </div>
    
</body>
</html>";


        $email = (new Email())
            ->from('ahmeddouss35@gmail.com')
            ->to($user->getMail())
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Confera Invitation')
            ->text($qrCodeImage->getDataUri())
            ->html($htmlContent)
            ->attach($qrCodeImage->getString(), 'QrInvitation.png', 'image/png');
        try {
            $response = $mailtrap->emails()->send($email,'2840299'); // Email sending API (real)
            $flashy->info("Mail Sent to ".$user->getUsername());
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }

        return $this->redirectToRoute('app_uidcard_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }


}
