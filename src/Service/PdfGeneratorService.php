<?php
// src/Service/PdfGeneratorService.php

namespace App\Service;

use Dompdf\Dompdf;
use App\Entity\Sponsor;

class PdfGeneratorService
{
    private $dompdf;

    public function __construct()
    {
        $this->dompdf = new Dompdf();
    }

    public function generateSponsorPdf(Sponsor $sponsor): string
    {
        $html = $this->renderSponsorHtml($sponsor);
        $this->dompdf->loadHtml($html);
        $this->dompdf->setPaper('A4', 'portrait');
        $this->dompdf->render();

        return $this->dompdf->output();
    }

    private function renderSponsorHtml(Sponsor $sponsor): string
    {
       

    $html = <<<HTML
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sponsor Details</title>
        <style>
            body {
                font-family: Arial, sans-serif;
            }

            h1 {
                color: #333;
                font-size: 24px;
                margin-bottom: 20px;
            }

            p {
                margin-bottom: 10px;
            }

            .sponsor-details {
                margin-top: 30px;
                border-collapse: collapse;
                width: 100%;
            }

            .sponsor-details th,
            .sponsor-details td {
                border: 1px solid #ddd;
                padding: 8px;
            }

            .sponsor-details th {
                background-color: #f2f2f2;
                font-weight: bold;
            }

            .logo {
                max-width: 100px; /* Adjust size as needed */
            }
        </style>
    </head>
    <body>
        <h1>Sponsor Details</h1>


        <p><strong>Sponsor Details:</strong> Votre Sponsor a été bien enregistré</p>

        <table class="sponsor-details">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>NumTel</th>
                    <th>Email</th>
                    <th>Status</th>
                </tr>
            </thead>
            
            <tbody>
                <tr>
                    <td>{$sponsor->getNom()}</td>
                    <td>{$sponsor->getNumTel()}</td>
                    <td>{$sponsor->getEmail()}</td>
                    <td>{$sponsor->getStatus()}</td>
                </tr>
                
            </tbody>
        </table>
    </body>
    </html>
    HTML;
        return $html;
    }
}