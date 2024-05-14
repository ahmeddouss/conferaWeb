<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AdminregisterType;
use App\Form\RegistrationFormType;
use App\Form\UpdateType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Bridge\Google\Transport\GmailSmtpTransport;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use \Symfony\Bundle\SecurityBundle\Security;

class RegistrationController extends AbstractController
{

    /**
     * @throws TransportExceptionInterface
     */
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $passwordHasher, MailerInterface $mailer, UserRepository $userRepository, EntityManagerInterface $entityManager): Response
    {
        // Create a new User instance
        $user = new User();

        // Create the registration form with the User entity
        $form = $this->createForm(RegistrationFormType::class, $user);

        // Handle the form submission
        $form->handleRequest($request);

        // Check if the form is submitted and valid
        if ($form->isSubmitted() && $form->isValid()) {
            $email = $form->get('email')->getData();

            // Check if the email already exists
            $existingUser = $userRepository->findOneBy(['email' => $email]);

            if ($existingUser) {
                // Add a form error for the email field
                $form->get('email')->addError(new FormError('Email already exists.'));

                // Render the registration form with error message
                return $this->render('registration/register.html.twig', [
                    'registrationForm' => $form->createView(),
                ]);
            }
            // Get the password and confirmPassword from the form
            $password = $form->get('password')->getData();
            $confirmPassword = $form->get('confirmPassword')->getData();

            // Check if passwords match
            if ($password !== $confirmPassword) {
                // Add a form error for the confirmPassword field
                $form->get('confirmPassword')->addError(new FormError('Passwords do not match.'));

                // Render the registration form with error message
                return $this->render('registration/register.html.twig', [
                    'registrationForm' => $form->createView(),
                ]);
            }

            // Encode the plain password and set other user data
            $user->setPassword(
                $passwordHasher->hashPassword($user, $password)
            );
            $user->setRoles(['ROLE_USER']);

            // Save the user to the database
            $entityManager->persist($user);
            $entityManager->flush();


            // Redirect to a success page or login
            return $this->redirectToRoute('app_login');
        } else {
            // Display errors for debugging
            dump($form->getErrors(true, false));
        }

        // Render the registration form
        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/user/update', name: 'user_update', methods: ['GET', 'POST'])]
    public function updateUser(Request $request, EntityManagerInterface $entityManager, Security $security, UserPasswordHasherInterface $passwordHasher): Response
    {
        // Retrieve the authenticated user
        $user = $security->getUser();

        // Ensure the user is authenticated
        if (!$user instanceof User) {
            throw $this->createAccessDeniedException('User is not authenticated.');
        }

        $form = $this->createForm(UpdateType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Optionally, you can check if the password is changed and encode it
            if ($form->get('password')->getData()) {
                $user->setPassword(
                    $passwordHasher->hashPassword($user, $form->get('password')->getData())
                );
            }

            // Persist and flush the changes

            $entityManager->flush();

            // Redirect or do any other actions upon successful update
            return $this->redirectToRoute('user_update', ['id' => $user->getId()]);
        }

        return $this->render('user/profile.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }


    #[Route('/forgotpass', name: 'forgotpass')]
    public function forgotpass(Security $security): Response
    {
        return $this->render('registration/forgotpassword.html.twig');
    }

    /**
     * @throws TransportExceptionInterface
     * @throws \Exception
     */
    #[Route('/forgotpassemail', name: 'forgotpassemail')]
    public function forgotpassemail(Security $security, Request $request, MailerInterface $mailer, EntityManagerInterface $entityManager,UserPasswordHasherInterface $passwordHasher): Response
    {
        $email = $request->request->get('email');

        $user = $entityManager->getRepository(User::class)->findOneBy(['email' => $email]);

        if ($user) {
            // Generate a new password
            $newPassword = bin2hex(random_bytes(8)); // Change the length as needed

            // Encode and set the new password for the user
            $encodedPassword = $passwordHasher->hashPassword($user, $newPassword);
            $user->setPassword($encodedPassword);

            // Save the updated user entity to the database
            $entityManager->persist($user);
            $entityManager->flush();

            // Use Symfony's Mailer component to send the email
            $email = (new Email())
                ->from(new Address('confera.tn@gmail.com', 'confera.tn'))
                ->to($email)
                ->subject('Password Reset')
                ->text('Your new password is: ' . $newPassword);
            $transport = new GmailSmtpTransport('zayatihamza@gmail.com', 'uhkmccaxysbmuglm');
            $mailer = new Mailer($transport);
            $mailer->send($email);

            // Check user role and redirect accordingly

                return $this->redirectToRoute('app_login');
        } else {
            // User not found, return a response with an error message
            $errorMessage = 'Email not found. Please check your email address.';
            return $this->render('registration/forgotpassword.html.twig', ['error' => $errorMessage]);
            // Alternatively, you can use JsonResponse:
            // return new JsonResponse(['error' => $errorMessage], Response::HTTP_NOT_FOUND);
        }

        // Handle the case where the user is not found
        // You might want to add a flash message or error handling here


    }




//    #[Route('/user/profile', name: 'user_profile')]
//    public function userProfile(Security $security): Response
//    {
//        // Retrieve the authenticated user
//        $user = $security->getUser();
//
//        // Ensure the user is authenticated
//        if (!$user instanceof User) {
//            throw $this->createAccessDeniedException('User is not authenticated.');
//        }
//
//        return $this->render('user/profile.html.twig', [
//            'user' => $user,
//        ]);
//    }
}
