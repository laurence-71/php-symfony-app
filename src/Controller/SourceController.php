<?php

namespace App\Controller;

use App\Entity\Bike;
use App\Entity\Source;
use App\Form\BikeType;
use App\Form\SearchSourceType;
use App\Form\SourceType;
use App\Repository\SourceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/source")
 */
class SourceController extends AbstractController
{
    /**
     * @Route("/", name="source_index", methods={"GET"})
     */
    public function index(Request $request,SourceRepository $sourceRepository): Response
    {
        $limit = 5;
        $page = (int)$request->query->get("page",1);
        $sources = $sourceRepository->getPaginatedSource($page,$limit);
        $total = $sourceRepository->getTotalSource();
        return $this->render('source/index.html.twig', [
            'sources' => $sources,
            'limit'=>$limit,
            'page'=>$page,
            'total'=>$total,
        ]);
    }

     /**
     * @Route("/export", name="export_source_csv")
     */
    public function export(SourceRepository $sourceRepository):Response
    {
        $sourceList = $sourceRepository->findAll();
        $response = new StreamedResponse();
        $response->setCallback(
            function() use($sourceList){
                $handle = fopen('php://output','w+');
                fputs($handle, $bom=(chr(0xEF) . chr(0xBB) . chr(0xBF)));
                fputcsv($handle,['Id','Origin','Purpose','Deposit Date','Phone Number','Email','Address']);
                foreach($sourceList as $source)
                {
                    $data=[
                        $source->getId(),
                        $source->getOrigin(),
                        $source->getPurpose(),
                        $source->getDepositDate()->format('Y-m-d'),
                        $source->getTelephone(),
                        $source->getEmail(),
                        $source->getAddress(),
                      
                    ];
                    fputcsv($handle,$data);
                }
                fclose($handle);
            }
        );
        $response->headers->set('Content-Type', 'text/csv; charset=UTF-8');
        $response->headers->set('Content-disposition','attachment;filename=Source.csv');
        return $response;
    }

    /**
     * @Route("/search", name="search_source", methods={"GET", "POST"})
     */
    public function searchByOrigin(Request $request, SourceRepository $sourceRepository)
    {
        $source = new Source();
        $formSearchSource = $this->createForm(SearchSourceType::class, $source);
        $formSearchSource->handleRequest($request);

        if($formSearchSource->isSubmitted() && $formSearchSource->isValid())
        {
            $results = $sourceRepository->findByOrigin($source->getOrigin());
        }else{
            $results = [];
        }
        return $this->render('source/search.html.twig',[
            'results'=>$results,
            'formSearchSource'=>$formSearchSource->createView(),
        ]);
    }

    /**
     * @Route("/new", name="source_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $source = new Source();
        $formSource = $this->createForm(SourceType::class, $source);
        $formSource->handleRequest($request);

        if ($formSource->isSubmitted() && $formSource->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($source);
            $entityManager->flush();

            return $this->redirectToRoute('source_show', ['id'=>$source->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('source/new.html.twig', [
            'source' => $source,
            'formSource' => $formSource,
        ]);
    }

    /**
     * @Route("/{id}", name="source_show", methods={"GET"})
     */
    public function show(Source $source): Response
    {
        return $this->render('source/show.html.twig', [
            'source' => $source,
        ]);
    }

    /**
     * @Route("/{id}/addBike", name="add_bike", methods={"GET", "POST"})
     */
    public function addBike(Request $request, Source $source)
    {
        $bike = new Bike();
        $formBike = $this->createForm(BikeType::class, $bike);
        $formBike->handleRequest($request);

        if($formBike->isSubmitted() && $formBike->isValid())
        {
            $entityManager= $this->getDoctrine()->getManager();
            $bike->setSource($source);
            $entityManager->persist($bike);
            $entityManager->flush();

            $this->addFlash('message', "The bike has been added with success");
            return $this->redirectToRoute('bike_show',['id'=>$bike->getId()]);
        }
        return $this->render('bike/new.html.twig',[
            'bike'=>$bike,
            'formBike'=>$formBike->createView(),
        ]);

    }

    /**
     * @Route("/{id}/edit", name="source_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Source $source): Response
    {
        $formSource = $this->createForm(SourceType::class, $source);
        $formSource->handleRequest($request);

        if ($formSource->isSubmitted() && $formSource->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('source_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('source/edit.html.twig', [
            'source' => $source,
            'formSource' => $formSource,
        ]);
    }

    /**
     * @Route("/{id}", name="source_delete", methods={"POST"})
     */
    public function delete(Request $request, Source $source): Response
    {
        if ($this->isCsrfTokenValid('delete'.$source->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($source);
            $entityManager->flush();
        }

        return $this->redirectToRoute('source_index', [], Response::HTTP_SEE_OTHER);
    }
}
