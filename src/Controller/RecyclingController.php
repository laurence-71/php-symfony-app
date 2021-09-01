<?php

namespace App\Controller;

use App\Entity\Recycling;
use App\Entity\SecondHandStock;
use App\Entity\Transformation;
use App\Entity\Trash;
use App\Form\RecyclingType;
use App\Form\SecondHandStockType;
use App\Form\TransformationType;
use App\Form\TrashType;
use App\Repository\RecyclingRepository;
use App\Repository\SecondHandStockRepository;
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
     * @Route("/{id}/addSecondHandStock", name="add_secondHand_stock", methods={"GET","POST"})
     */
    public function addSecondHandStock(SecondHandStockRepository $secondHandStockRepository,Request $request, Recycling $recycling)
    {
        $secondHandStock = new SecondHandStock();
        $formSecondhandStock = $this->createForm(SecondHandStockType::class,$secondHandStock);
        $formSecondhandStock->handleRequest($request);

        if($formSecondhandStock->isSubmitted() && $formSecondhandStock->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();
            $result= $secondHandStockRepository->findOneByLabelBrand($secondHandStock->getLabel(),$secondHandStock->getBrand());
            if($result != null)
            {
                $result->setQuantity($secondHandStock->getQuantity() + $result->getQuantity());
               $recycling->addSecondHandStock($result);
                            }else{
                    $recycling->addSecondHandStock($secondHandStock);
                    $entityManager->persist($secondHandStock);
                }
                $entityManager->persist($recycling);
                $entityManager->flush();
                return $this->redirectToRoute('recycling_show',['id'=>$recycling->getId()]);
        }
        return $this->render('second_hand_stock/new.html.twig',[
            'secondHandStock'=>$secondHandStock,
            'formSecondHandStock'=>$formSecondhandStock->createView(),
        ]);
    }

    /**
     * @Route("/{id}/addTransformation", name="add_transformation", methods={"GET","POST"})
     */
    public function addTransformation(Request $request, Recycling $recycling)
    {
        $transformation = new Transformation();
        $formTransformation = $this->createForm(TransformationType::class,$transformation);
        $formTransformation->handleRequest($request);

        if($formTransformation->isSubmitted() && $formTransformation->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();
            $recycling->addTransformation($transformation);
            $entityManager->persist($transformation);
            $entityManager->flush();

            return $this->redirectToRoute('recycling_show',['id'=>$recycling->getId()]);
        }
        return $this->render('transformaton/new.html.twig',[
            'transformation'=>$transformation,
            'formTransformation'=>$formTransformation->createView(),
        ]);
    }

    /**
     * @Route("/{id}/addTrash", name="add_trash", methods={"GET","POST"})
     */
    public function addTrash(Request $request, Recycling $recycling)
    {
        $trash = new Trash();
        $formTrash = $this->createForm(TrashType::class, $trash);
        $formTrash->handleRequest($request);

        if($formTrash->isSubmitted() && $formTrash->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();
            $recycling->addTrash($trash);
            $entityManager->persist($trash);
            $entityManager->flush();

            return $this->redirectToRoute('recycling_show',['id'=>$recycling->getId()]);
        }
        return $this->render('trash/new.html.twig',[
            'trash'=>$trash,
            'formTrash'=>$formTrash->createView(),

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
