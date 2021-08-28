<?php

namespace App\Controller;

use App\Entity\Transformation;
use App\Form\TransformationType;
use App\Repository\TransformationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/transformation")
 */
class TransformationController extends AbstractController
{
    /**
     * @Route("/", name="transformation_index", methods={"GET"})
     */
    public function index(TransformationRepository $transformationRepository): Response
    {
        return $this->render('transformation/index.html.twig', [
            'transformations' => $transformationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="transformation_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $transformation = new Transformation();
        $formTransformation = $this->createForm(TransformationType::class, $transformation);
        $formTransformation->handleRequest($request);

        if ($formTransformation->isSubmitted() && $formTransformation->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($transformation);
            $entityManager->flush();

            return $this->redirectToRoute('transformation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('transformation/new.html.twig', [
            'transformation' => $transformation,
            'formTransformation' => $formTransformation,
        ]);
    }

    /**
     * @Route("/{id}", name="transformation_show", methods={"GET"})
     */
    public function show(Transformation $transformation): Response
    {
        return $this->render('transformation/show.html.twig', [
            'transformation' => $transformation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="transformation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Transformation $transformation): Response
    {
        $formTransformation = $this->createForm(TransformationType::class, $transformation);
        $formTransformation->handleRequest($request);

        if ($formTransformation->isSubmitted() && $formTransformation->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('transformation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('transformation/edit.html.twig', [
            'transformation' => $transformation,
            'formTransformation' => $formTransformation,
        ]);
    }

    /**
     * @Route("/{id}", name="transformation_delete", methods={"POST"})
     */
    public function delete(Request $request, Transformation $transformation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$transformation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($transformation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('transformation_index', [], Response::HTTP_SEE_OTHER);
    }
}
