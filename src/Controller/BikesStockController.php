<?php

namespace App\Controller;

use App\Entity\BikesStock;
use App\Form\BikesStockType;
use App\Repository\BikesStockRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/bikes/stock")
 */
class BikesStockController extends AbstractController
{
    /**
     * @Route("/", name="bikes_stock_index", methods={"GET"})
     */
    public function index(BikesStockRepository $bikesStockRepository): Response
    {
        return $this->render('bikes_stock/index.html.twig', [
            'bikes_stocks' => $bikesStockRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="bikes_stock_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $bikesStock = new BikesStock();
        $formBikesStock = $this->createForm(BikesStockType::class, $bikesStock);
        $formBikesStock->handleRequest($request);

        if ($formBikesStock->isSubmitted() && $formBikesStock->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($bikesStock);
            $entityManager->flush();

            return $this->redirectToRoute('bikes_stock_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('bikes_stock/new.html.twig', [
            'bikes_stock' => $bikesStock,
            'formBikesStock' => $formBikesStock,
        ]);
    }

    /**
     * @Route("/{id}", name="bikes_stock_show", methods={"GET"})
     */
    public function show(BikesStock $bikesStock): Response
    {
        return $this->render('bikes_stock/show.html.twig', [
            'bikes_stock' => $bikesStock,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="bikes_stock_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, BikesStock $bikesStock): Response
    {
        $formBikesStock = $this->createForm(BikesStockType::class, $bikesStock);
        $formBikesStock->handleRequest($request);

        if ($formBikesStock->isSubmitted() && $formBikesStock->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('bikes_stock_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('bikes_stock/edit.html.twig', [
            'bikes_stock' => $bikesStock,
            'formBikesStock' => $formBikesStock,
        ]);
    }

    /**
     * @Route("/{id}", name="bikes_stock_delete", methods={"POST"})
     */
    public function delete(Request $request, BikesStock $bikesStock): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bikesStock->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($bikesStock);
            $entityManager->flush();
        }

        return $this->redirectToRoute('bikes_stock_index', [], Response::HTTP_SEE_OTHER);
    }
}
