<?php

namespace App\Form;

use App\Entity\Annoncef;
use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints as Assert;

class AnnoncefType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomf',TextType::class,['attr' =>['style' => 'color :rgb(64,0,64);border:1px solid black;width:500px;margin-left:182px;margin-top:20px'],'label' => 'nom','label_attr'=>['style'=>'font-weight:bold']])
            ->add('adresse',TextType::class,['attr' =>['style' => 'color :rgb(64,0,64);border:1px solid black;width:500px;margin-left:160px;margin-top:20px'],'label' => 'adresse','label_attr'=>['style'=>'font-weight:bold']])
            ->add('emailf',TextType::class,['attr' =>['style' => 'color :rgb(64,0,64);border:1px solid black;width:500px;margin-left:176px;margin-top:20px'],'label' => 'email','label_attr'=>['style'=>'font-weight:bold']])
            ->add('descf',TextType::class,['attr' =>['style' => 'color :rgb(64,0,64);border:1px solid black;width:500px;margin-left:137px;margin-top:20px'],'label' => 'description','label_attr'=>['style'=>'font-weight:bold']])
            ->add('idu',EntityType::class,['class'=> Utilisateur::class,
            'choice_label'=>'nom',
            'label'=>'nom utilisateur'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Annoncef::class,
        ]);
    }
}
