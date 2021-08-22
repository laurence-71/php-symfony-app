<?php

namespace App\Controller;

use App\Entity\Recycling;
use App\Form\RecyclingType;
use App\Repository\RecyclingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/recycling")
 */
class RecyclingController extends AbstractController
{
    /**
     * @Route("/", name="recycling_index", methods={"GET"})
     */
    public function index(RecyclingRepository $recyclingRepository): Response
    {
        return $this->render('recycling/index.html.twig', [
            'recyclings' => $recyclingRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="recycling_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $recycling = new Recycling();
        $formRecycling = $this->createForm(RecyclingType::class, $recycling);
        $formRecycling->handleRequest($request);

        if ($formRecycling->isSubmitted() && $formRecycling->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($recycling);
            $entityManager->flush();

            return $this->redirectToRoute('recycling_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('recycling/new.html.twig', [
            'recycling' => $recycling,
            'formRecycling' => $formRecycling,
        ]);
    }

    /**
     * @Route("/{id}", name="recycling_show", methods={"GET"})
     */
    public function show(Recycling $recycling): Response
    {
        return $this->render('recycling/show.html.twig', [
            'recycling' => $recycling,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="recycling_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Recycling $recycling): Response
    {
        $formRecycling= $this->createForm(RecyclingType::class, $recycling);
        $formRecycling->handleRequest($request);

        if ($formRecycling->isSubmitted() && $formRecycling->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('recycling_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('recycling/edit.html.twig', [
            'recycling' => $recycling,
            'formRecycling' => $formRecycling,
        ]);
    }

    /**
     * @Route("/{id}", name="recycling_delete", methods={"POST"})
     */
    public function delete(Request $request, Recycling $recycling): Response
    {
        if ($this->isCsrfTokenValid('delete'.$recycling->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($recycling);
            $entityManager->flush();
        }

        return $this->redirectToRoute('recycling_index', [], Response::HTTP_SEE_OTHER);
    }
}
