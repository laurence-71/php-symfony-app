<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EditUserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

 /**
     * @Route("/admin", name="admin_")
     */
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }

    /**
     * @Route("userList", name="users", methods={"GET"})
     */
    public function usersList(UserRepository $userRepository)
    {
        return $this->render("admin/index.html.twig",[
            'users'=>$userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/users/edit/{id}", name="edit_user", methods={"GET","POST"})
     */
    public function editUser(User $user, Request $request)
    {
        $formEditUser = $this->createForm(EditUserType::class,$user);
        $formEditUser->handleRequest($request);

        if($formEditUser->isSubmitted() && $formEditUser->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('message',"The user role has been change succefully");
            return $this->redirectToRoute("admin_users");
        }
        return $this->render('admin/editUser.html.twig',[
            'formEditUser'=>$formEditUser->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="delete_user", methods={"POST"})
     */
    public function delete(Request $request, User $user)
    {
        if($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token')))
        {
            $entityManager= $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }
        return $this->redirectToRoute('admin_users');
    }
}
