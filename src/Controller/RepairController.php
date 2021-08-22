<?php

namespace App\Controller;

use App\Entity\Repair;
use App\Form\RepairType;
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
