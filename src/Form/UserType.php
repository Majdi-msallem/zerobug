<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email')
            ->add('phone')
            ->add('name')
            ->add('cin')
            ->add('roles',choiceType::class, [
                'choices' =>[
                    'Administrateur'=>'ROLE_ADMIN',
                    'Utilisateur'=> 'ROLE_USER',
                    
                ],

                'multiple'=>true,
                'label'=>'roles'
            ])
            ->add('genre',choiceType::class,[
                'choices' =>[
                'Homme'=>'homme',
                'femme'=>'femme'
            ],
                'multiple'=>false,
        'label'=>'genre'
            ])
            ->add('password')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
