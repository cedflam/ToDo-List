<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class,[
                'label'=> "Username",
                'attr'=> [
                    'placeholder'=> "Entrez un nom d'utilisateur ..."
                ]
            ])
            ->add('email', EmailType::class, [
                'attr'=> [
                    'placeholder'=> "Entrez votre adresse email ..."
                ]
            ])
            ->add('role', ChoiceType::class,[
                'label'=> "Autorisations de l'utilisateur",
                'choices'=> [
                    'Selectionnez un role ...'=> "",
                    'Utilisateur'=> 'ROLE_USER',
                    'Administrateur' => 'ROLE_ADMIN'

                ]
            ])
            ->add('password', PasswordType::class, [
                'label'=> "Mot de passe",
                'attr'=> [
                    'placeholder'=> "Saisir un mor de passe d'au moins 6 caractères ..."
                ]
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
