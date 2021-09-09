<?php

namespace App\Controller;

use App\Entity\SecondHandStock;
use App\Form\SearchSecondHandArticleType;
use App\Form\SecondHandStockType;
use App\Repository\SecondHandStockRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/second/hand/stock")
 */
class SecondHandStockController extends AbstractController
{
    /**
     * @Route("/", name="second_hand_stock_index", methods={"GET"})
     */
    public function index(SecondHandStockRepository $secondHandStockRepository): Response
    {
        return $this->render('second_hand_stock/index.html.twig', [
            'second_hand_stocks' => $secondHandStockRepository->findAll(),
        ]);
    }

    /**
     * @Route("/searchSecondhandArticle",name="search_second_hand_article", methods={"GET","POST"})
     */
    public function searchSecondHandArticle(Request $request, SecondHandStockRepository $secondHandStockRepository)
    {
        $secondHandStock = new SecondHandStock();
        $formSearchSecondHandArticle = $this->createForm(SearchSecondHandArticleType::class,$secondHandStock);
        $formSearchSecondHandArticle->handleRequest($request);

        if($formSearchSecondHandArticle->isSubmitted() && $formSearchSecondHandArticle->isValid())
        {
            $results = $secondHandStockRepository->findByLabel($secondHandStock->getLabel());
        }else{
            $results = [];
        }
        return $this->render('second_hand_stock/search_second_hand_article.html.twig',[
            'results'=>$results,
            'formSearchSecondHandArticle'=>$formSearchSecondHandArticle->createView(),
        ]);
    }

    /**
     * @Route("/new", name="second_hand_stock_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $secondHandStock = new SecondHandStock();
        $formSecondhandStock = $this->createForm(SecondHandStockType::class, $secondHandStock);
        $formSecondhandStock->handleRequest($request);

        if ($formSecondhandStock->isSubmitted() && $formSecondhandStock->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($secondHandStock);
            $entityManager->flush();

            return $this->redirectToRoute('second_hand_stock_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('second_hand_stock/new.html.twig', [
            'second_hand_stock' => $secondHandStock,
            'formSecondHandStock' => $formSecondhandStock,
        ]);
    }

    /**
     * @Route("/{id}", name="second_hand_stock_show", methods={"GET"})
     */
    public function show(SecondHandStock $secondHandStock): Response
    {
        return $this->render('second_hand_stock/show.html.twig', [
            'second_hand_stock' => $secondHandStock,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="second_hand_stock_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, SecondHandStock $secondHandStock): Response
    {
        $formSecondhandStock = $this->createForm(SecondHandStockType::class, $secondHandStock);
        $formSecondhandStock->handleRequest($request);

        if ($formSecondhandStock->isSubmitted() && $formSecondhandStock->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('second_hand_stock_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('second_hand_stock/edit.html.twig', [
            'second_hand_stock' => $secondHandStock,
            'formSecondHandStock' => $formSecondhandStock,
        ]);
    }

    /**
     * @Route("/{id}", name="second_hand_stock_delete", methods={"POST"})
     */
    public function delete(Request $request, SecondHandStock $secondHandStock): Response
    {
        if ($this->isCsrfTokenValid('delete'.$secondHandStock->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($secondHandStock);
            $entityManager->flush();
        }

        return $this->redirectToRoute('second_hand_stock_index', [], Response::HTTP_SEE_OTHER);
    }
}
