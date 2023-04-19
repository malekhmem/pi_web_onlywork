<?php

namespace App\Form;

<<<<<<< HEAD:src/Form/UserType.php
use App\Entity\User;
=======
use App\Entity\Users;
>>>>>>> c3f0276de4fcc57cf16fbe8e0a97e3ecdce9a53f:src/Form/UsersType.php
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

<<<<<<< HEAD:src/Form/UserType.php

class UserType extends AbstractType
=======
use Symfony\Component\Validator\Constraints as Assert;

class UsersType extends AbstractType
>>>>>>> c3f0276de4fcc57cf16fbe8e0a97e3ecdce9a53f:src/Form/UsersType.php
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
<<<<<<< HEAD:src/Form/UserType.php
            ->add('email')
            ->add('plainpassword', TextType::class, [
                'mapped' => false
            ])
            ->add('isVerified')
=======
            ->add('login')
            ->add('password')
            ->add('nom')
            ->add('prenom')
            ->add('email')
            ->add('num_tel')
            
            ->add('role')
            ->add('etat')
>>>>>>> c3f0276de4fcc57cf16fbe8e0a97e3ecdce9a53f:src/Form/UsersType.php
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
<<<<<<< HEAD:src/Form/UserType.php
            'data_class' => User::class,
=======
            'data_class' => Users::class,
            'validation_groups' => ['Default', 'registration'],
>>>>>>> c3f0276de4fcc57cf16fbe8e0a97e3ecdce9a53f:src/Form/UsersType.php
        ]);
    }
}
