<?php

namespace App\Form;

use App\Entity\Liste;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use App\Form\AjoutVocabulaireType;
use App\Entity\Vocabulaire;

class AjoutListeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',TextType::class)
            ->add('listeMots', EntityType::class, [
                'class'     => Vocabulaire::class,
                'choice_label' => 'mot',
                'label'     => 'Quel sera le mot?',
                'expanded'  => true,
                'multiple'  => true,
            ])
            ->add('idEntreprise',EntityType::Class,['class' => 'App\Entity\Entreprise','choice_label' => 'libelle', 'required'=> false])
            ->add('theme',EntityType::Class,array('class' => 'App\Entity\Theme','choice_label' => 'libelle'))
            ->add('ajouter', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Liste::class,
        ]);
    }
}
