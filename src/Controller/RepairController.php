<?php

namespace App\Controller;

use App\Entity\BikeArticle;
use App\Entity\Repair;
use App\Entity\Requirement;
use App\Form\BikeArticleType;
use App\Form\RepairType;
use App\Form\RepairValidationType;
use App\Form\RequirementType;
use App\Repository\RepairRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/repair")
 */
class RepairController extends AbstractController
{
    /**
     * @Route("/", name="repair_index", methods={"GET"})
     */
    public function index(RepairRepository $repairRepository): Response
    {
        return $this->render('repair/index.html.twig', [
            'repairs' => $repairRepository->findAll(),
        ]);
    }

    /**
     * @Route("/currentRepairList", name="current_repair_list", methods={"GET"})
     */
    public function currentRepairList(RepairRepository $repairRepository)
    {
        return $this->render('repair/currentRepairList.html.twig',[
            'currentRepairList'=>$repairRepository->findBy(["validation"=>null],["takingCareDate"=>"DESC"]),

        ]);
    }

    /**
     * @Route("/new", name="repair_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $repair = new Repair();
        $formRepair = $this->createForm(RepairType::class, $repair);
        $formRepair->handleRequest($request);

        if ($formRepair->isSubmitted() && $formRepair->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($repair);
            $entityManager->flush();

            return $this->redirectToRoute('repair_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('repair/new.html.twig', [
            'repair' => $repair,
            'formRepair' => $formRepair,
        ]);
    }

    /**
     * @Route("/{id}", name="repair_show", methods={"GET"})
     */
    public function show(Repair $repair): Response
    {
        return $this->render('repair/show.html.twig', [
            'repair' => $repair,
        ]);
    }

    /**
     * @Route("/{id}/estimate", name="repair_estimate", methods={"GET"})
     */
    public function estimate(Repair $repair):Response
    {
        return $this->render('repair/estimate.html.twig',[
            'repair'=>$repair,
        ]);
    }

    /**
     *@Route("/{id}/check_bike_part", name="check_bike_part", methods={"GET","POST"})
     */
    public function checkBikePart(Request $request, Repair $repair)
    {
        $bikeArticle = new BikeArticle();
        $formBikeArticle = $this->createForm(BikeArticleType::class,$bikeArticle);
        $formBikeArticle->handleRequest($request);

        if($formBikeArticle->isSubmitted() && $formBikeArticle->isValid())
        {
            $entityManager= $this->getDoctrine()->getManager();
            $repair->addBikeArticle($bikeArticle);
            $entityManager->persist($bikeArticle);
            $entityManager->flush();

            return $this->redirectToRoute('bike_article_show',['id'=>$repair->getId()]);
        }
        return $this->render('bike_article/new.html.twig',[
            'bikeArticle'=>$bikeArticle,
            'formBikeArticle'=>$formBikeArticle->createView(),
        ]);
    }

    /**
     * @Route("/{id}/addRequirement", name="add_requirement", methods={"GET","POST"})
     */
    public function addRequirement(Request $request, Repair $repair)
    {
        $requirement = new Requirement();
        $formRequirement = $this->createForm(RequirementType::class,$requirement);
        $formRequirement->handleRequest($request);

        if($formRequirement->isSubmitted() && $formRequirement->isValid())
        {
            $entityManager= $this->getDoctrine()->getManager();
           $repair->setRequirement($requirement);
           $entityManager->persist($requirement);
           $entityManager->persist($repair);
           $entityManager->flush();

           return $this->redirectToRoute('requirement_show',['id'=>$repair->getId()]);

        }
        return $this->render('requirement/new.html.twig',[
            'requirement'=>$requirement,
            'formRequirement'=>$formRequirement->createView(),
        ]);
    }

    /**
     * @Route("/{id}/repairValidation", name="repair_validation",methods={"GET","POST"})
     */
    public function repairValidation(Request $request, Repair $repair)
    {
        $formRepairValidation = $this->createForm(RepairValidationType::class,$repair);
        $formRepairValidation->handleRequest($request);

        if($formRepairValidation->isSubmitted() && $formRepairValidation->isValid())
        {
            $entityManager= $this->getDoctrine()->getManager();
            $entityManager->persist($repair);
            $entityManager->flush();

            return $this->redirectToRoute('operation_show',['id'=>$repair->getId()]);
        }
        return $this->render('repair/validation.html.twig',[
            'repairValidation'=>$repair,
            'formRepairValidation'=>$formRepairValidation->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="repair_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Repair $repair): Response
    {
        $formRepair = $this->createForm(RepairType::class, $repair);
        $formRepair->handleRequest($request);

        if ($formRepair->isSubmitted() && $formRepair->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('repair_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('repair/edit.html.twig', [
            'repair' => $repair,
            'formRepair' => $formRepair,
        ]);
    }

    /**
     * @Route("/{id}", name="repair_delete", methods={"POST"})
     */
    public function delete(Request $request, Repair $repair): Response
    {
        if ($this->isCsrfTokenValid('delete'.$repair->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($repair);
            $entityManager->flush();
        }

        return $this->redirectToRoute('repair_index', [], Response::HTTP_SEE_OTHER);
    }
}
