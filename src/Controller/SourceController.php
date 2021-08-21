<?php

namespace App\Controller;

use App\Entity\Source;
use App\Form\SourceType;
use App\Repository\SourceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/source")
 */
class SourceController extends AbstractController
{
    /**
     * @Route("/", name="source_index", methods={"GET"})
     */
    public function index(SourceRepository $sourceRepository): Response
    {
        return $this->render('source/index.html.twig', [
            'sources' => $sourceRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="source_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $source = new Source();
        $form = $this->createForm(SourceType::class, $source);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($source);
            $entityManager->flush();

            return $this->redirectToRoute('source_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('source/new.html.twig', [
            'source' => $source,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="source_show", methods={"GET"})
     */
    public function show(Source $source): Response
    {
        return $this->render('source/show.html.twig', [
            'source' => $source,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="source_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Source $source): Response
    {
        $form = $this->createForm(SourceType::class, $source);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('source_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('source/edit.html.twig', [
            'source' => $source,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="source_delete", methods={"POST"})
     */
    public function delete(Request $request, Source $source): Response
    {
        if ($this->isCsrfTokenValid('delete'.$source->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($source);
            $entityManager->flush();
        }

        return $this->redirectToRoute('source_index', [], Response::HTTP_SEE_OTHER);
    }
}
