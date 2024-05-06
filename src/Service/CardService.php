<?php

namespace App\Service;


use App\Entity\Uidcard;
use App\Repository\UidcardRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Response;

class CardService
{
    public function addCardUid(): string
    {
        // Call the testPin method of the TestPinService
        $url = 'http://192.168.1.21/rfid';

        // Create a new HttpClient instance
        $httpClient = HttpClient::create();

        // Make the HTTP request
        try {
            // Send GET request
            $response = $httpClient->request('GET', $url);


            // Extract the first 8 characters
            $content = substr($response->getContent(), 0, 8);

        } catch (\Throwable $e) {
            // Handle errors
            echo "Error occurred: " . $e->getMessage();
        }

        // Optionally, return a response
        return $content;
    }
    public function verifNewCard(string $cardUid,EntityManagerInterface $entityManager): bool
    {
        // Get the repository for Uidcard entity
        $uidcardRepository = $entityManager->getRepository(Uidcard::class);

        // Find if the cardUid exists in the table
        $uidcard = $uidcardRepository->findOneBy(['uid' => $cardUid]);

        // If uidcard is found, return true
        if ($uidcard !== null) {
            return false;
        }

        return true;
    }

    public function getLastStatus(string $cardUid,UidcardRepository $uidcardRepository): int
    {
        $card= $uidcardRepository->findByUidWithMaxStatus($cardUid);
        return $card->getStatus();
    }
}