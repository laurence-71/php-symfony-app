<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface as HasherUserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    private $userHasher;

    public function __construct(HasherUserPasswordHasherInterface $userHasher)
    {
        $this->userHasher = $userHasher;
    }

    /**
     * @Route("/registration", name="registration")
     */
    public function index(Request $request): Response
    {
        $user = new User();
        $formUser = $this->createForm(UserType::class,$user);
        $formUser->handleRequest($request);

        if($formUser->isSubmitted() && $formUser->isValid())
        {
            $user->setPassword($this->userHasher->hashPassword($user,$user->getPassword()));
            $user->setRoles(['ROLE_USER']);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_login');

        }
        return $this->render('registration/index.html.twig', [
            'formUser' => $formUser->createView(),
        ]);
    }
}
