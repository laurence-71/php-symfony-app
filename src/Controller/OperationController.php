<?php

namespace App\Controller;

use App\Entity\Operation;
use App\Form\OperationType;
use App\Repository\OperationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/operation")
 */
class OperationController extends AbstractController
{
    /**
     * @Route("/", name="operation_index", methods={"GET"})
     */
    public function index(OperationRepository $operationRepository): Response
    {
        return $this->render('operation/index.html.twig', [
            'operations' => $operationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="operation_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $operation = new Operation();
        $form = $this->createForm(OperationType::class, $operation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($operation);
            $entityManager->flush();

            return $this->redirectToRoute('operation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('operation/new.html.twig', [
            'operation' => $operation,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="operation_show", methods={"GET"})
     */
    public function show(Operation $operation): Response
    {
        return $this->render('operation/show.html.twig', [
            'operation' => $operation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="operation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Operation $operation): Response
    {
        $form = $this->createForm(OperationType::class, $operation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('operation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('operation/edit.html.twig', [
            'operation' => $operation,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="operation_delete", methods={"POST"})
     */
    public function delete(Request $request, Operation $operation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$operation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($operation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('operation_index', [], Response::HTTP_SEE_OTHER);
    }
}
