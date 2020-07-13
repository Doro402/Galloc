<?php

namespace App\Form;

use App\Entity\Chambre;
use App\Entity\Etudiant;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class EtudiantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('matricule')
            ->add('nom', TextType::class, [
                'constraints' =>[ 
                    new NotBlank(),
                    new Length([
                        'min'=>2,
                    ])
                ],
                'attr'=>['class' => 'form-control'],
            ])
            ->add('prenom', TextType::class, [
                'constraints' =>[ 
                    new NotBlank(),
                    new Length([
                        'min'=>2,
                    ])
                ],
                'attr'=>['class' => 'form-control'],
            ])
            ->add('email')
            ->add('telephone')
            ->add('boursier', ChoiceType::class, [
                'choices'=>[
                    'Oui'=>true,
                    'Non'=>false
                ],
                'attr'=>['class' => 'form-control'],
            ])
            ->add('loge', ChoiceType::class, [
                'choices'=>[
                    'Oui'=>true,
                    'Non'=>false
                ],
                'attr'=>['class' => 'form-control'],
                'placeholder'=>'Choisir ',
                'mapped'=>false,
                'required'=>false
            ])
            ->add('adresse')
            ->add('montant_bourse', ChoiceType::class, [
                'choices'=>[
                    '40000'=>'entier',
                    '20000'=>'demi',
                    
                ],
                'placeholder'=>'Choisir le montant',
                'required'=>false,
                'attr'=>['class' => 'form-control form-control-lg'],
            ])
            ->add('chambre', EntityType::class,[
                'class'=>Chambre::class,
                'choice_label'=>'numero',
                'placeholder'=>'Choisir une chambre',
                'required'=>false,
                'attr'=>['class' => 'form-control'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Etudiant::class,
        ]);
    }
}
