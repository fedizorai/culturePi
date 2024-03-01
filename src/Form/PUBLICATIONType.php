<?php

namespace App\Form;

use App\Entity\PUBLICATION;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PUBLICATIONType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('CONTENUPUB')
            ->add('DATEPUB')
            ->add('USERNAME')
            ->add('USERID')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PUBLICATION::class,
        ]);
    }
}
