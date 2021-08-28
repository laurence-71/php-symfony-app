<?php

namespace App\Controller;

use App\Entity\Trash;
use App\Form\TrashType;
use App\Repository\TrashRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/trash")
 */
class TrashController extends AbstractController
{
    /**
     * @Route("/", name="trash_index", methods={"GET"})
     */
    public function index(TrashRepository $trashRepository): Response
    {
        return $this->render('trash/index.html.twig', [
            'trashes' => $trashRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="trash_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $trash = new Trash();
        $formTrash = $this->createForm(TrashType::class, $trash);
        $formTrash->handleRequest($request);

        if ($formTrash->isSubmitted() && $formTrash->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($trash);
            $entityManager->flush();

            return $this->redirectToRoute('trash_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('trash/new.html.twig', [
            'trash' => $trash,
            'formTrash' => $formTrash,
        ]);
    }

    /**
     * @Route("/{id}", name="trash_show", methods={"GET"})
     */
    public function show(Trash $trash): Response
    {
        return $this->render('trash/show.html.twig', [
            'trash' => $trash,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="trash_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Trash $trash): Response
    {
        $formTrash = $this->createForm(TrashType::class, $trash);
        $formTrash->handleRequest($request);

        if ($formTrash->isSubmitted() && $formTrash->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('trash_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('trash/edit.html.twig', [
            'trash' => $trash,
            'formTrash' => $formTrash,
        ]);
    }

    /**
     * @Route("/{id}", name="trash_delete", methods={"POST"})
     */
    public function delete(Request $request, Trash $trash): Response
    {
        if ($this->isCsrfTokenValid('delete'.$trash->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($trash);
            $entityManager->flush();
        }

        return $this->redirectToRoute('trash_index', [], Response::HTTP_SEE_OTHER);
    }
}
