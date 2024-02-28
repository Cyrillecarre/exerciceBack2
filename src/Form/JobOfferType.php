<?php

namespace App\Form;

use App\Entity\JobOffer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JobOfferType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('name', null, [
            'attr' => ['class' => 'form-control col-6 mx-auto m-3','style' => 'width: 50%', 'placeholder' => 'Nom de l\'offre'],
            'label' => false,
        ])
        ->add('city', null, [
            'attr' => ['class' => 'form-control col-6 mx-auto m-3','style' => 'width: 50%', 'placeholder' => 'Ville'],
            'label' => false,
        ])
        ->add('schedules', null, [
            'attr' => ['class' => 'form-control col-6 mx-auto m-3','style' => 'width: 50%', 'placeholder' => 'Horaires'],
            'label' => false,
        ])
        ->add('salary', null, [
            'attr' => ['class' => 'form-control col-6 mx-auto m-3','style' => 'width: 50%', 'placeholder' => 'Salaire'],
            'label' => false,
        ]);
        //->add('isPublished', CheckboxType::class, [ 
        //    'label' => 'En attente de validation',
        //    'data' => false,
        //]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => JobOffer::class,
        ]);
    }
}
