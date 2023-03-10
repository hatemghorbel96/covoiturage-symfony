<?php

namespace App\Form;

use App\Entity\Ad;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AdType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            
            ->add('ville')
            ->add('destination')
            ->add('montant')
            ->add('phone')
            ->add('marque')
            ->add('nbp')
            ->add('image',FileType::class, [
                'attr'=>['class'=>'form-control form-control-sm'],
                'label'=> '',
                'data_class' => null,
                'required' => true])
        
            ->add('datecov',DateType::class,[
                'widget'=>'single_text'
            ])
            ->add('timecov',TimeType::class,[
                'widget'=>'single_text'
            ])
           
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ad::class,
        ]);
    }
}
