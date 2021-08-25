<?php

namespace App\Controller;

use App\Entity\NewStock;
use App\Entity\Requirement;
use App\Entity\SecondHandStock;
use App\Form\NewStockType;
use App\Form\RequirementType;
use App\Form\SecondHandStockType;
use App\Repository\NewStockRepository;
use App\Repository\RequirementRepository;
use App\Repository\SecondHandStockRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/requirement")
 */
class RequirementController extends AbstractController
{
    /**
     * @Route("/", name="requirement_index", methods={"GET"})
     */
    public function index(RequirementRepository $requirementRepository): Response
    {
        return $this->render('requirement/index.html.twig', [
            'requirements' => $requirementRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="requirement_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $requirement = new Requirement();
        $formRequirement = $this->createForm(RequirementType::class, $requirement);
        $formRequirement->handleRequest($request);

        if ($formRequirement->isSubmitted() && $formRequirement->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($requirement);
            $entityManager->flush();

            return $this->redirectToRoute('requirement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('requirement/new.html.twig', [
            'requirement' => $requirement,
            'formRequiremnt' => $formRequirement,
        ]);
    }

    /**
     * @Route("/{id}", name="requirement_show", methods={"GET"})
     */
    public function show(Requirement $requirement): Response
    {
        return $this->render('requirement/show.html.twig', [
            'requirement' => $requirement,
        ]);
    }

    /**
     * @Route("/{id}/addNewStock", name="add_new_stock", methods={"GET","POST"})
     */
    public function addNewStock(Request $request,NewStockRepository $newStockRepository ,Requirement $requirement)
    {
       $newStock = new NewStock();
       $formNewStock = $this->createForm(NewStockType::class,$newStock);
       $formNewStock->handleRequest($request);

       if($formNewStock->isSubmitted() && $formNewStock->isValid())
       {
           $entityManager= $this->getDoctrine()->getManager();
           $result = $newStockRepository->findOneByLabelBrandQuantity($newStock->getLabel(), $newStock->getBrand(),$newStock->getQuantity());
           if ($result !=null)
            {
              $requirement->addNewStock($result);
           } else {
              $requirement->addNewStock($newStock);
              $entityManager->persist($newStock);
           }
           $entityManager->persist($requirement);
           $entityManager->flush();
           
           return $this->redirectToRoute('requirement_show',['id'=>$requirement->getId()]);
       }
       return $this->render('new_stock/new.html.twig',[
           'newStock'=>$newStock,
           'formNewStock'=>$formNewStock->createView(),
       ]);
    }

    /**
     * @Route("/{id}/addSecondHandStock", name="add_second_hand_stock", methods={"GET","POST"})
     */
    public function addSecondHandStock(Request $request,SecondHandStockRepository $secondHandStockRepository, Requirement $requirement)
    {
        $secondHandStock = new SecondHandStock();
        $formSecondHandStock = $this->createForm(SecondHandStockType::class,$secondHandStock);
        $formSecondHandStock->handleRequest($request);

        if($formSecondHandStock->isSubmitted() && $formSecondHandStock->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();
            $result=$secondHandStockRepository->findOneByLabelBrandQuantity($secondHandStock->getLabel(),$secondHandStock->getBrand(),$secondHandStock->getQuantity());

            if($result != null)
            {
                $requirement->addSecondHandStock($result);
            }else{
                $requirement->addSecondHandStock($secondHandStock);
                $entityManager->persist($secondHandStock);
            }
            $entityManager->persist($requirement);
            $entityManager->flush();

            return $this->redirectToRoute('requirement_show',['id'=>$requirement->getId()]);
        }
        return $this->render('second_hand_stock/new.html.twig',[
            'secondHandStock'=>$secondHandStock,
            'formSecondHandStock'=>$formSecondHandStock->createView(),
        ]);
    }




    /**
     * @Route("/{id}/edit", name="requirement_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Requirement $requirement): Response
    {
        $formRequirement = $this->createForm(RequirementType::class, $requirement);
        $formRequirement->handleRequest($request);

        if ($formRequirement->isSubmitted() && $formRequirement->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('requirement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('requirement/edit.html.twig', [
            'requirement' => $requirement,
            'formRequirement' => $formRequirement,
        ]);
    }

    /**
     * @Route("/{id}", name="requirement_delete", methods={"POST"})
     */
    public function delete(Request $request, Requirement $requirement): Response
    {
        if ($this->isCsrfTokenValid('delete'.$requirement->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($requirement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('requirement_index', [], Response::HTTP_SEE_OTHER);
    }
}
