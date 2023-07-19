<?php

namespace App\Form;

use App\Entity\Cars;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Validator\Constraints\PositiveOrZero;

class CarsUpdateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('modele', TextType::class, [
                'label' => 'Modèle du véhicule',
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        "message" => "Veuillez indiquer le modèle du véhicule"
                    ])
                ]
            ])
            ->add('year', IntegerType::class, [
                'label' => 'Année de mise en circulation',
                'required' => true,
                'constraints' => [
                    new Positive([
                        'message' => 'Veuillez indiquez une année valide'
                    ]),
                    new NotBlank([
                        "message" => "Veuillez indiquer l'année de mise en circulation du véhicule"
                    ])
                ]
            ])
            ->add('mileage', IntegerType::class, [
                'label' => 'Kilométrage du véhicule',
                'required' => true,
                'constraints' => [
                    new PositiveOrZero([
                        'message' => 'Veuillez indiquer une valeur positive'
                    ]),
                    new NotBlank([
                        "message" => "Veuillez indiquer l'année de mise en circulation du véhicule"
                    ])
                ]
            ])
            ->add('price', IntegerType::class, [
                'label' => 'Prix du véhicule',
                'required' => true,
                'constraints' => [
                    new Positive([
                        'message' => 'Veuillez indiquer un prix valide'
                    ]),
                    new NotBlank([
                        "message" => "Veuillez indiquer le prix du véhicule"
                    ])
                ]
            ])
            ->add('valider', SubmitType::class);;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cars::class,
        ]);
    }
}
