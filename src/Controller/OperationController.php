<?php

namespace App\Controller;

use App\Entity\BikesStock;
use App\Entity\Billing;
use App\Entity\Operation;
use App\Entity\Operator;
use App\Entity\Recycling;
use App\Entity\Repair;
use App\Form\BikesStockType;
use App\Form\BillingType;
use App\Form\OperationType;
use App\Form\OperatorType;
use App\Form\RecyclingType;
use App\Form\RepairType;
use App\Form\SearchOperationType;
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
    public function index(Request $request,OperationRepository $operationRepository): Response
    {
        $limit=5;
        $page=(int)$request->query->get("page",1);
        $operations = $operationRepository->getPaginatedOperation($page,$limit);
        $total=$operationRepository->getTotalOperation();

        return $this->render('operation/index.html.twig', [
            'operations' => $operations,
            'limit'=>$limit,
            'page'=>$page,
            'total'=>$total,
        ]);
    }

    /**
     * @Route("/searchOperation", name="search_operation", methods={"GET","POST"})
     */
    public function searchOperation(Request $request,OperationRepository $operationRepository)
    {
        $operation = new Operation();
     

        $formSearchOperation = $this->createForm(SearchOperationType::class,$operation);
        $formSearchOperation->handleRequest($request);

        if($formSearchOperation->isSubmitted() && $formSearchOperation->isValid())
        {
            $results = $operationRepository->findByDate($operation->getReceptionDate());
        }else{
            $results = [];
        }
       
        return $this->render('operation/search_date.html.twig',[
            'results'=>$results,
          
            'formSearchOperation'=>$formSearchOperation->createView(),
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
     * @Route("/{id}/addRepair", name="add_repair", methods={"GET","POST"})
     */
    public function addRepair(Request $request,Operation $operation)
    {
        $repair = new Repair();
        $formRepair= $this->createForm(RepairType::class,$repair);
        $formRepair->handleRequest($request);

        if($formRepair->isSubmitted() && $formRepair->isValid())
        {
            $entityManager= $this->getDoctrine()->getManager();
            $operation->setRepair($repair);
            $entityManager->persist($repair);
            $entityManager->persist($operation);
            $entityManager->flush();

            return $this->redirectToRoute('check_bike_part',['id'=>$repair->getId()]);
        }
        return $this->render('repair/new.html.twig',[
            'repair'=>$repair,
            'formRepair'=>$formRepair->createView(),
        ]);
    }

    /**
     * @Route("/{id}/addBilling", name="add_billing",methods={"GET","POST"})
     */
    public function addBilling(Request $request, Operation $operation)
    {
        $billing = new Billing();
        $formBilling = $this->createForm(BillingType::class,$billing);
        $formBilling->handleRequest($request);

        if($formBilling->isSubmitted() && $formBilling->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();
            $operation->setBilling($billing);
            $entityManager->persist($billing);
            $entityManager->persist($operation);
            $entityManager->flush();

            return $this->redirectToRoute('billing_show',['id'=>$billing->getId()]);
        }
        return $this->render('billing/new.html.twig',[
            'billing'=>$billing,
            'formBilling'=>$formBilling->createView(),
        ]);
    }

    /**
     * @Route("/{id}/addRecycling", name="add_recycling", methods={"GET", "POST"})
     */
    public function addRecycling(Request $request, Operation $operation){
        $recycling = new Recycling();
        $formRecycling = $this->createForm(RecyclingType::class, $recycling);
        $formRecycling->handleRequest($request);

        if($formRecycling->isSubmitted() && $formRecycling->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();
            $operation->setRecycling($recycling);
            $entityManager->persist($operation);
            $entityManager->persist($recycling);
            $entityManager->flush();

            return $this->redirectToRoute('recycling_show',['id'=>$recycling->getId()]);
        }
        return $this->render('recycling/new.html.twig',[
            'recycling'=>$recycling,
            'formRecycling'=>$formRecycling->createView(),
        ]);
    }

    /**
     * @Route("/{id}/addBikesStock", name="add_bikes_stock",methods={"GET","POST"})
     */
    public function addBikesStock(Request $request, Operation $operation)
    {
        $bikesStock = new BikesStock();
        $formBikesStock = $this->createForm(BikesStockType::class, $bikesStock);
        $formBikesStock->handleRequest($request);

        if($formBikesStock->isSubmitted() && $formBikesStock->isValid())
        {
            $entityManager= $this->getDoctrine()->getManager();
            $bikesStock->setOperation($operation);
            $entityManager->persist($bikesStock);
            $entityManager->persist($operation);
            $entityManager->flush();

            return $this->redirectToRoute('bikes_stock_show',['id'=>$bikesStock->getId()]);

        }
        return $this->render('bikes_stock/new.html.twig',[
            'bikesStock'=>$bikesStock,
            'formBikesStock'=>$formBikesStock->createView(),
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
