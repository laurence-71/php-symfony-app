<?php

namespace App\Controller;

use App\Entity\NewStock;
use App\Form\NewStockType;
use App\Form\SearchNewArticleType;
use App\Repository\NewStockRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/new/stock")
 */
class NewStockController extends AbstractController
{
    /**
     * @Route("/", name="new_stock_index", methods={"GET"})
     */
    public function index(NewStockRepository $newStockRepository): Response
    {
        return $this->render('new_stock/index.html.twig', [
            'new_stocks' => $newStockRepository->findAll(),
        ]);
    }

    /**
     * @Route("searchNewArticle", name="search_new_article", methods={"GET","POST"})
     */
    public function searchNewArticle(Request $request, NewStockRepository $newStockRepository)
    {
        $newStock = new NewStock();
        $formSearchNewArticle = $this->createForm(SearchNewArticleType::class, $newStock);
        $formSearchNewArticle->handleRequest($request);

        if($formSearchNewArticle->isSubmitted() && $formSearchNewArticle->isValid())
        {
            $results = $newStockRepository->findByLabel($newStock->getLabel());
        }else{
            $results = [];
        }
        return $this->render('new_stock/search_new_article.html.twig',[
            'results'=>$results,
            'formSearchNewArticle'=>$formSearchNewArticle->createView(),
        ]);
    }
    
    /**
     * @Route("/new", name="new_stock_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $newStock = new NewStock();
        $formNewStock = $this->createForm(NewStockType::class, $newStock);
        $formNewStock->handleRequest($request);

        if ($formNewStock->isSubmitted() && $formNewStock->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newStock);
            $entityManager->flush();

            return $this->redirectToRoute('new_stock_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('new_stock/new.html.twig', [
            'new_stock' => $newStock,
            'formNewStock' => $formNewStock,
        ]);
    }

    /**
     * @Route("/{id}", name="new_stock_show", methods={"GET"})
     */
    public function show(NewStock $newStock): Response
    {
        return $this->render('new_stock/show.html.twig', [
            'new_stock' => $newStock,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="new_stock_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, NewStock $newStock): Response
    {
        $formNewStock = $this->createForm(NewStockType::class, $newStock);
        $formNewStock->handleRequest($request);

        if ($formNewStock->isSubmitted() && $formNewStock->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('new_stock_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('new_stock/edit.html.twig', [
            'new_stock' => $newStock,
            'formNewStock' => $formNewStock,
        ]);
    }

    /**
     * @Route("/{id}", name="new_stock_delete", methods={"POST"})
     */
    public function delete(Request $request, NewStock $newStock): Response
    {
        if ($this->isCsrfTokenValid('delete'.$newStock->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($newStock);
            $entityManager->flush();
        }

        return $this->redirectToRoute('new_stock_index', [], Response::HTTP_SEE_OTHER);
    }
}
