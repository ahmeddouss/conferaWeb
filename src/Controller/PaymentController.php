<?php

namespace App\Controller;

use Stripe\Checkout\Session;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use App\Service\PdfGenerator;

class PaymentController extends AbstractController
{
    
    private $params;
   
    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
    }
   

    #[Route('/payment', name: 'app_payment')]
    public function index(): Response
    {
        return $this->render('payment/index.html.twig', [
            'controller_name' => 'PaymentController',
        ]);
    }

    #[Route('/checkout', name: 'checkout')]
    public function checkout(): Response
    {
        $stripeSK = $this->params->get('stripe_secret_key');
        Stripe::setApiKey($stripeSK);

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items'           => [
                [
                    'price_data' => [
                        'currency'     => 'usd',
                        'product_data' => [
                            'name' => 'Conference',
                        ],
                        'unit_amount'  => 2000.000,
                    ],
                    'quantity'   => 1,
                ]
            ],
            'mode'                 => 'payment',
            'success_url'          => $this->generateUrl('success_url', [], UrlGeneratorInterface::ABSOLUTE_URL),
            'cancel_url'           => $this->generateUrl('cancel_url', [], UrlGeneratorInterface::ABSOLUTE_URL),
        ]);
        

        return $this->redirect($session->url, 303);
    }

    #[Route('/success-url', name: 'success_url')]
public function successUrl(): Response
{
    // Predefined values for email, moyendepaiement, and date
    $email = 'amenallah@gmail.com';
    $moyendepaiement = 'visa';
    $date = new \DateTime(); // Current date and time

    return $this->render('payment/success.html.twig', [
        'email' => $email,
        'moyendepaiement' => $moyendepaiement,
        'date' => $date,
    ]);
}

    #[Route('/cancel-url', name: 'cancel_url')]
    public function cancelUrl(): Response
    {
        return $this->render('payment/cancel.html.twig', []);
    }
}
