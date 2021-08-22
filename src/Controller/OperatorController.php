<?php

namespace App\Controller;

use App\Entity\Operator;
use App\Form\OperatorType;
use App\Repository\OperatorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/operator")
 */
class OperatorController extends AbstractController
{
    /**
     * @Route("/", name="operator_index", methods={"GET"})
     */
    public function index(OperatorRepository $operatorRepository): Response
    {
        return $this->render('operator/index.html.twig', [
            'operators' => $operatorRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="operator_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $operator = new Operator();
        $formOperator = $this->createForm(OperatorType::class, $operator);
        $formOperator->handleRequest($request);

        if ($formOperator->isSubmitted() && $formOperator->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($operator);
            $entityManager->flush();

            return $this->redirectToRoute('operator_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('operator/new.html.twig', [
            'operator' => $operator,
            'formOperator' => $formOperator,
        ]);
    }

    /**
     * @Route("/{id}", name="operator_show", methods={"GET"})
     */
    public function show(Operator $operator): Response
    {
        return $this->render('operator/show.html.twig', [
            'operator' => $operator,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="operator_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Operator $operator): Response
    {
        $formOperator = $this->createForm(OperatorType::class, $operator);
        $formOperator->handleRequest($request);

        if ($formOperator->isSubmitted() && $formOperator->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('operator_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('operator/edit.html.twig', [
            'operator' => $operator,
            'formOperator' => $formOperator,
        ]);
    }

    /**
     * @Route("/{id}", name="operator_delete", methods={"POST"})
     */
    public function delete(Request $request, Operator $operator): Response
    {
        if ($this->isCsrfTokenValid('delete'.$operator->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($operator);
            $entityManager->flush();
        }

        return $this->redirectToRoute('operator_index', [], Response::HTTP_SEE_OTHER);
    }
}
