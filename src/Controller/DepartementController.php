<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\DepartementRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Departement;
use App\Form\DepartementType;

class DepartementController extends AbstractController
{
    /**
     * @Route("/departement", name="departement")
     */
    public function index(DepartementRepository $departementRepository): Response
    {
        return $this->render('departement/index.html.twig', [
            'departements' => $departementRepository->findAll(),
        ]);
        /* $auteurRepository->findAll():
        récupéré tous les auteurs et l'envoyer vers index.ht.twig */
    }

    /**
     * @Route("/{id}/edit", name="departement_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Departement $departement): Response
    {
        $form = $this->createForm(DepartementType::class, $departement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('departement');
        }

        return $this->render('departement/edit.html.twig', [
            'departement' => $departement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/departement/new", name="departement_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $departement = new Departement();
        $form = $this->createForm(DepartementType::class, $departement);
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
            $entityManager->persist($departement);
            // exécute réellement les requêtes (c'est-à-dire la requête INSERT)
            $entityManager->flush();
            // redirection vers la page d'accueil
            return $this->redirectToRoute('departement');
        }

        return $this->render('departement/new.html.twig', [
            'departement' => $departement,
            'form' => $form->createView(),
        ]);
    }
}
