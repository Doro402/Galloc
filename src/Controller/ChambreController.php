<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ChambreType;
use App\Repository\ChambreRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Chambre;
use Knp\Component\Pager\PaginatorInterface;

class ChambreController extends AbstractController
{
    /**
     * @Route("/chambre", name="chambre")
     */
    public function index(PaginatorInterface $paginator,Request $request): Response
    {
        $donnees = $this->getDoctrine()->getRepository(Chambre::class)->findBy([],['id' => 'asc']);
        // Paginate the results of the query
        $chambres = $paginator->paginate(
            // Doctrine Query, not results
            $donnees,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            4
        );
        return $this->render('chambre/index.html.twig', [
            'chambres' => $chambres,
        ]);
        /* $auteurRepository->findAll():
        récupéré tous les auteurs et l'envoyer vers index.ht.twig */
    }

    /**
     * @Route("/chambre/new", name="chambre_new", methods={"GET","POST"})
     */
    public function new(Request $request,ChambreRepository $c): Response
    {
        $chambre = new Chambre();
        // $chambre->setNumero('152');
        $form = $this->createForm(ChambreType::class, $chambre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /*
            vous pouvez récupérer l'EntityManager via $this->getDoctrine ()
            ou vous pouvez ajouter un argument à votre action:
            createAction (EntityManagerInterface $entityManager)
            */
            $entityManager = $this->getDoctrine()->getManager();
            //indique à Doctrine que vous souhaitez
            //(éventuellement) enregistrer le produit (pas encore de requêtes)
            $entityManager->persist($chambre);
            // exécute réellement les requêtes (c'est-à-dire la requête INSERT)
            $entityManager->flush();
            // redirection vers la page d'accueil
            return $this->redirectToRoute('chambre');
        }

        $nbchambre=count($c->findAll())+1;
        return $this->render('chambre/new.html.twig', [
            'chambre' => $chambre,
            'nbchambre'=>$nbchambre,
            'form' => $form->createView(),
        ]);
    }


     /**
     * @Route("/chambre/{id}/edit", name="chambre_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Chambre $chambre): Response
    {
        $form = $this->createForm(ChambreType::class, $chambre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('chambre');
        }

        return $this->render('chambre/edit.html.twig', [
            'chambre' => $chambre,
            'form' => $form->createView(),
        ]);
    }

}
