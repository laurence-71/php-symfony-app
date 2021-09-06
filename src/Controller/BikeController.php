<?php

namespace App\Controller;

use App\Entity\Bike;
use App\Entity\Operation;
use App\Form\BikeType;
use App\Form\OperationType;
use App\Repository\BikeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/bike")
 */
class BikeController extends AbstractController
{
    /**
     * @Route("/", name="bike_index", methods={"GET"})
     */
    public function index(BikeRepository $bikeRepository): Response
    {
        return $this->render('bike/index.html.twig', [
            'bikes' => $bikeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="bike_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $bike = new Bike();
        $formBike = $this->createForm(BikeType::class, $bike);
        $formBike->handleRequest($request);

        if ($formBike->isSubmitted() && $formBike->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($bike);
            $entityManager->flush();

            return $this->redirectToRoute('bike_show', ['id'=>$bike->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('bike/new.html.twig', [
            'bike' => $bike,
            'formBike' => $formBike,
        ]);
    }

    /**
     * @Route("/{id}", name="bike_show", methods={"GET"})
     */
    public function show(Bike $bike): Response
    {
        return $this->render('bike/show.html.twig', [
            'bike' => $bike,
        ]);
    }

    /**
     * @Route("/{id}/addOperation", name="add_operation", methods={"GET","POST"})
     */
    public function addOperation(Request $request, Bike $bike)
    {
        $operation = new Operation();
        $formOperation= $this->createForm(OperationType::class,$operation);
        $formOperation->handleRequest($request);

        if($formOperation->isSubmitted() && $formOperation->isValid())
        {
            $entityManager= $this->getDoctrine()->getManager();
            $bike->addOperation($operation);
            $entityManager->persist($operation);
            $entityManager->flush();

            return $this->redirectToRoute('operation_show',['id'=>$operation->getId()]);
        }
        return $this->render('operation/new.html.twig',[
            'operation'=>$operation,
            'formOperation'=>$formOperation->createView(),
        ]);
    }


    /**
     * @Route("/{id}/edit", name="bike_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Bike $bike): Response
    {
        $formBike = $this->createForm(BikeType::class, $bike);
        $formBike->handleRequest($request);

        if ($formBike->isSubmitted() && $formBike->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('bike_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('bike/edit.html.twig', [
            'bike' => $bike,
            'formBike' => $formBike,
        ]);
    }

    /**
     * @Route("/{id}", name="bike_delete", methods={"POST"})
     */
    public function delete(Request $request, Bike $bike): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bike->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($bike);
            $entityManager->flush();
        }

        return $this->redirectToRoute('bike_index', [], Response::HTTP_SEE_OTHER);
    }
}
