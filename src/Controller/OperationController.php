<?php

namespace App\Controller;

use App\Entity\Operation;
use App\Entity\Operator;
use App\Form\OperationType;
use App\Form\OperatorType;
use App\Repository\OperationRepository;
use App\Repository\OperatorRepository;
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
        $formOperation = $this->createForm(OperationType::class, $operation);
        $formOperation->handleRequest($request);

        if ($formOperation->isSubmitted() && $formOperation->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($operation);
            $entityManager->flush();

            return $this->redirectToRoute('operation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('operation/new.html.twig', [
            'operation' => $operation,
            'formOperation' => $formOperation,
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
     * @Route("/{id}/addOperator", name="add_operator", methods={"GET", "POST"})
     */
    public function addOperator(Request $request, OperatorRepository $operatorRepository, Operation $operation)
    {
        $operator = new Operator();
        $formOperator= $this->createForm(OperatorType::class,$operator);
        $formOperator->handleRequest($request);

        if($formOperator->isSubmitted() && $formOperator->isValid())
        {
            $entityManager= $this->getDoctrine()->getManager();
            $result = $operatorRepository->findOneByLastNameFirstName($operator->getLastName(),$operator->getFirstName());
            if($result !=null)
            {
                $operation->addOperator($result);
            }else{
                $operation->addOperator($operator);
                $entityManager->persist($operator);

            }
            $entityManager->persist($operation);
            $entityManager->flush();

            $this->addFlash('message', 'The operator has been added with success');
            return $this->redirectToRoute('operation_show',['id'=>$operation->getId()]);
        }
        return $this->render('operator/new.html.twig',[
            'operator'=>$operator,
            'formOperator'=>$formOperator->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="operation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Operation $operation): Response
    {
        $formOperation = $this->createForm(OperationType::class, $operation);
        $formOperation->handleRequest($request);

        if ($formOperation->isSubmitted() && $formOperation->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('operation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('operation/edit.html.twig', [
            'operation' => $operation,
            'formOperation' => $formOperation,
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
