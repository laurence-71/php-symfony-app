<?php

namespace App\Controller;

use App\Entity\NewStock;
use App\Entity\Requirement;
use App\Entity\SecondHandStock;
use App\Form\NewStockRequirementType;
use App\Form\NewStockType;
use App\Form\RequirementType;
use App\Form\SecondHandStockRequirementType;
use App\Form\SecondHandStockType;
use App\Repository\NewStockRepository;
use App\Repository\RequirementRepository;
use App\Repository\SecondHandStockRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
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
            'formRequirement' => $formRequirement,
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
     * @Route("/{id}/addNewArticle", name="add_new_article", methods={"GET","POST"})
     */
    public function addNewArticle(Request $request,NewStockRepository $newStockRepository, Requirement $requirement)
    {  
        $newStock = new NewStock();
        $formNewStock = $this->createForm(NewStockRequirementType::class, $newStock);
        $formNewStock->handleRequest($request);

        if($formNewStock->isSubmitted() && $formNewStock->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();
            $result = $newStockRepository->findOneByLabelBrand($newStock->getLabel(), $newStock->getBrand());
         
            if($result != null)
            {
                $requirement->addNewStock($result);
                $result->setQuantity($result->getQuantity()-$newStock->getRequirementQuantity());
                $result->setRequirementQuantity($newStock->getRequirementQuantity());
            }else{
                $this->addFlash("message","No  new stock for this article");
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
     * @Route("/{id}/addSecondHandArticle", name="add_second_hand_article", methods={"GET","POST"})
     */
    public function addSecondHandArticle(Request $request, SecondHandStockRepository $secondHandStockRepository, Requirement $requirement)
    {
        $secondHandStock = new SecondHandStock();
        $formSecondHandStock = $this->createForm(SecondHandStockRequirementType::class,$secondHandStock);
        $formSecondHandStock->handleRequest($request);
        
        if($formSecondHandStock->isSubmitted() && $formSecondHandStock->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();
            $result = $secondHandStockRepository->findOneByLabelBrand($secondHandStock->getLabel(), $secondHandStock->getBrand());

            if($result != null)
            {
                $requirement->addSecondHandStock($result);
                $result->setRequirementQuantity($secondHandStock->getRequirementQuantity());
                $result->setQuantity($result->getQuantity() - $secondHandStock->getRequirementQuantity());

            }else{
                $this->addFlash('message',"No second-hand stock for this article");
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
