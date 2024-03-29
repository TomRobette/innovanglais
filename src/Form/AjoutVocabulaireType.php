<?php

namespace App\Form;

use App\Entity\Vocabulaire;
use App\Entity\Categorie;
use App\Entity\Langue;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class AjoutVocabulaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('mot', TextType::class)
            ->add('categorie', EntityType::class,
            array('class' => 'App\Entity\Categorie',        
            'choice_label' => 'libelle'))
            ->add('lang', EntityType::class,
            array('class' =>  'App\Entity\Langue',        
            'choice_label' => 'nom'))
            ->add('ajouter', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Vocabulaire::class,
        ]);
    }
}
