<?php

namespace App\Form;

use App\Entity\Poste;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class PosteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomp',TextType::class,['attr' =>['style' => 'color :rgb(64,0,64);border:1px solid black;width:500px;margin-left:180px;margin-top:20px'],'label' => 'nom','label_attr'=>['style'=>'font-weight:bold']])
            ->add('domaine',TextType::class,['attr' =>['style' => 'color :rgb(64,0,64);border:1px solid black;width:500px;margin-left:155px;margin-top:20px'],'label' => 'domaine','label_attr'=>['style'=>'font-weight:bold']])
            ->add('descp',TextType::class,['attr' =>['style' => 'color :rgb(64,0,64);border:1px solid black;width:500px;margin-left:140px;margin-top:20px'],'label' => 'description','label_attr'=>['style'=>'font-weight:bold']])
            ->add('emailp',TextType::class,['attr' =>['style' => 'color :rgb(64,0,64);border:1px solid black;width:500px;margin-left:182px;margin-top:20px'],'label' => 'email','label_attr'=>['style'=>'font-weight:bold']])
            ->add('idcc')
            ->add('idu')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Poste::class,
        ]);
    }
}
