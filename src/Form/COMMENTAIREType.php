<?php

namespace App\Form;

use App\Entity\COMMENTAIRE;
use App\Entity\PUBLICATION;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class COMMENTAIREType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('CONTENUCOM')
            ->add('DATECOM')
            ->add('NAME')
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => COMMENTAIRE::class,
        ]);
    }
}
