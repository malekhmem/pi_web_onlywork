<?php

namespace App\Form;

use App\Entity\Materiel;
#use App\Entity\Annoncef;
#use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class MaterielType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomm',TextType::class,['attr' =>['style' => 'color :rgb(64,0,64);border:1px solid black;width:500px;margin-left:182px;margin-top:20px'],'label' => 'nom','label_attr'=>['style'=>'font-weight:bold']])
            ->add('marque',TextType::class,['attr' =>['style' => 'color :rgb(64,0,64);border:1px solid black;width:500px;margin-left:160px;margin-top:20px'],'label' => 'marque','label_attr'=>['style'=>'font-weight:bold']])
            ->add('prix',TextType::class,['attr' =>['style' => 'color :rgb(64,0,64);border:1px solid black;width:500px;margin-left:182px;margin-top:20px'],'label' => 'Price','label_attr'=>['style'=>'font-weight:bold']])
            ->add('descm',TextType::class,['attr' =>['style' => 'color :rgb(64,0,64);border:1px solid black;width:500px;margin-left:138px;margin-top:20px'],'label' => 'description','label_attr'=>['style'=>'font-weight:bold']])
            #->add('image')
           ->add('image',FileType::class, ['attr' =>['style' => 'color :rgb(64,0,64);border:1px solid black;width:500px;margin-left:217px;margin-top:-15px'],'label' => 'Image','label_attr'=>['style'=>'font-weight:bold'],
               
            'mapped' => false,
            'required' => true,
            'constraints' => [
                new File([
                    'maxSize' => '1024k',
                    'mimeTypes' => [
                        'image/jpg',
                        'image/jpeg',
                        'image/png',
                    ],
                    'mimeTypesMessage' => 'Inserer une image validee',
                ])]
                ])

           # ->add('idff')
          
           ->add('idff')
            ->add('idu')
            
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Materiel::class,
        ]);
    }
}
