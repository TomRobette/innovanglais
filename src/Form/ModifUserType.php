<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class ModifUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('email', EmailType::Class)
        /*   ->add('roles')*/
           ->add('password', PasswordType::Class)
           ->add('confirmation', PasswordType::class,['mapped'=>false])
           ->add('abonnement',EntityType::Class,array('class' => 'App\Entity\Abonnement','choice_label' => 'libelle'))
           ->add('entreprise',EntityType::Class,['class' => 'App\Entity\Entreprise','choice_label' => 'libelle','required'=> false])
           ->add('send', SubmitType::class);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
