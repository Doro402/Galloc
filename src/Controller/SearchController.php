<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    /**
     * @Route("/search", name="search")
     */
    public function index()
    {
        return $this->render('search/index.html.twig', [
            'controller_name' => 'SearchController',
        ]);
    }


    public function searchBar()
    {
        $form = $this->createFormBuilder(null)
            ->add('search', TextType::class,[
                'label'=>'Rechercher '
            ])
            ->add('Rechercher', SubmitType::class, [
                'attr'=>[
                    'class'=>'btn btn-primary',
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

        return $this->render('search/searchBar.html.twig',[
            'form'=>$form->createView(),
        ]);
              
       
    }
}
