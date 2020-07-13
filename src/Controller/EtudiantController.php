<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\EtudiantType;
use App\Repository\EtudiantRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Etudiant;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

// use Doctrine\Persistence\ObjectManager;
// use PhpParser\Node\Expr\Cast\Object_;

class EtudiantController extends AbstractController
{
    /**
     * @Route("/etudiant", name="etudiant")
     */
    public function index(PaginatorInterface $paginator, Request $request)
    {
        // =================== Recherche ===================
        $form = $this->createFormBuilder(null)
            ->add('search', SearchType::class)
            ->add('send', SubmitType::class, [
                'attr'=>[
                    'class'=>'btn btn-primary'
                ]
            ])
            ->getForm()
        ;
              
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $em = $this->container->get('doctrine')->getManager();
            $etudiant = $em->getRepository('App\Entity\Etudiant')->search($data['form_search']);
            return $this->render('pages/Searchresult.html.twig', [
                'etudiants' => $etudiant
            ]);
        }
        // =================================================

        $donnees = $this->getDoctrine()->getRepository(Etudiant::class)->findBy([], ['id' => 'asc']);
        // Paginate the results of the query
        $etudiants = $paginator->paginate(
            // Doctrine Query, not results
            $donnees,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            4
        );

        return $this->render('etudiant/index.html.twig', [
            'form'=> $form->createView(),
            'etudiants' => $etudiants,
        ]);
        // return $this->render('etudiant/index.html.twig', [
        //     'controller_name' => 'EtudiantController',
        // ]);
    }

    /**
     * @Route("/etudiant/new", name="etudiant_new", methods={"GET","POST"})
     */
    public function new(Request $request, EtudiantRepository $etud, EntityManagerInterface $manager): Response
    {
        // dump($request);
        // if ($request->request->count()>0){
        //     $etudiant=new Etudiant();
        //     $etudiant->setMatricule($request->request->get('mat_etud'))
        //              ->setNom($request->request->get('nom_etud'))
        //              ->setPrenom($request->request->get('prenom_etud'))
        //              ->setEmail($request->request->get('email_etud'))
        //              ->setTelephone($request->request->get('tel_etud'));
        //              if ($request->request->get('bourse_etud') == "boursier") {
        //                  $etudiant->setBoursier(1)
        //                           ->setMontantBourse($request->request->get('m_bourse'));
        //              }else{
        //                 $etudiant->setBoursier(1)
        //                 ->setAdresse($request->request->get('addr_etud'))
        //                 ->setBoursier(0);
        //              }

        //              $manager->persist($etudiant);
        //              $manager->flush();

        //             //  return 
        // }

        // $etudiants=$etud->findAll();

        // return $this->render('etudiant\new.html.twig', [
        //     "etudiants"=> $etudiants,
        // ]);
        // $form = $this->createFormB
        $etudiant = new Etudiant();
        $form = $this->createForm(EtudiantType::class, $etudiant);
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
            $entityManager->persist($etudiant);
            // exécute réellement les requêtes (c'est-à-dire la requête INSERT)
            $entityManager->flush();
            // redirection vers la page d'accueil
            return $this->redirectToRoute('etudiant');
        }
        $nbetudiants = count($etud->findAll()) + 1;
        return $this->render('etudiant/new.html.twig', [
            'etudiant' => $etudiant,
            'nbetudiants' => $nbetudiants,
            'form' => $form->createView(),
        ]);
    }
}
