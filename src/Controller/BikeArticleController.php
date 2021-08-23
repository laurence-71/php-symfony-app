<?php

namespace App\Controller;

use App\Entity\BikeArticle;
use App\Form\BikeArticleType;
use App\Repository\BikeArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/bike/article")
 */
class BikeArticleController extends AbstractController
{
    /**
     * @Route("/", name="bike_article_index", methods={"GET"})
     */
    public function index(BikeArticleRepository $bikeArticleRepository): Response
    {
        return $this->render('bike_article/index.html.twig', [
            'bike_articles' => $bikeArticleRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="bike_article_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $bikeArticle = new BikeArticle();
        $formBikeArticle = $this->createForm(BikeArticleType::class, $bikeArticle);
        $formBikeArticle->handleRequest($request);

        if ($formBikeArticle->isSubmitted() && $formBikeArticle->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($bikeArticle);
            $entityManager->flush();

            return $this->redirectToRoute('bike_article_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('bike_article/new.html.twig', [
            'bike_article' => $bikeArticle,
            'formBikeArticle' => $formBikeArticle,
        ]);
    }

    /**
     * @Route("/{id}", name="bike_article_show", methods={"GET"})
     */
    public function show(BikeArticle $bikeArticle): Response
    {
        return $this->render('bike_article/show.html.twig', [
            'bike_article' => $bikeArticle,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="bike_article_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, BikeArticle $bikeArticle): Response
    {
        $formBikeArticle = $this->createForm(BikeArticleType::class, $bikeArticle);
        $formBikeArticle->handleRequest($request);

        if ($formBikeArticle->isSubmitted() && $formBikeArticle->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('bike_article_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('bike_article/edit.html.twig', [
            'bike_article' => $bikeArticle,
            'formBikeArticle' => $formBikeArticle,
        ]);
    }

    /**
     * @Route("/{id}", name="bike_article_delete", methods={"POST"})
     */
    public function delete(Request $request, BikeArticle $bikeArticle): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bikeArticle->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($bikeArticle);
            $entityManager->flush();
        }

        return $this->redirectToRoute('bike_article_index', [], Response::HTTP_SEE_OTHER);
    }
}
