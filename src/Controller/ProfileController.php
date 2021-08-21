<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EditProfileType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    /**
     * @Route("/profile", name="profile_index")
     */
    public function index(): Response
    {
        return $this->render('profile/index.html.twig');
    }

    /**
     * @Route("/profile/edit/{id}", name="edit_profile", methods={"GET","POST"})
     */
    public function editProfile(Request $request, User $user){
        $formEditProfile = $this->createForm(EditProfileType::class, $user);
        $formEditProfile->handleRequest($request);

        if($formEditProfile->isSubmitted() && $formEditProfile->isValid())
        {
            $entityManager=$this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('message',"The profile has been update");
            return $this->redirectToRoute('profile_index');
        }
        return $this->render('profile/editProfile.html.twig',[
            'formEditProfile'=>$formEditProfile->createView(),
        ]);
    }

    /**
     * @Route("/password/edit/{id}", name="edit_password")
     */
    public function editPassword(Request $request, User $user, UserPasswordHasherInterface $userPasswordHasher)
    {
        if($request->isMethod('POST'))
        {
            $entityManager= $this->getDoctrine()->getManager();

            if($request->request->get('pass') == $request->request->get('pass2')){
                $user->setPassword($userPasswordHasher->hashPassword($user, $request->request->get('pass')));
                $entityManager->flush();

                $this->addFlash('message','The Password has been update');
                return $this->redirectToRoute('profile_index');
            }else{
                $this->addFlash('error','Both password aren\'t the same');
            }
        } 
        return $this->render('profile/editPassword.html.twig');
    }
}
