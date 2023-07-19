<?php

namespace App\Form;

use App\Entity\Schedules;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class SchedulesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('monday', TextType::class, [
                'label' => 'lundi :',
                'required' => true,
                'attr' => [
                    'placeholder' => '08h45-12h00, 14h00-18h00',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner un horaire'
                    ])
                ]
            ])
            ->add('tuesday', TextType::class, [
                'label' => 'mardi :',
                'required' => true,
                'attr' => [
                    'placeholder' => '08h45-12h00, 14h00-18h00',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner un horaire'
                    ])
                ]
            ])
            ->add('wednesday', TextType::class, [
                'label' => 'mercredi :',
                'required' => true,
                'attr' => [
                    'placeholder' => '08h45-12h00, 14h00-18h00',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner un horaire'
                    ])
                ]
            ])
            ->add('thursday', TextType::class, [
                'label' => 'jeudi :',
                'required' => true,
                'attr' => [
                    'placeholder' => '08h45-12h00, 14h00-18h00',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner un horaire'
                    ])
                ]
            ])
            ->add('friday', TextType::class, [
                'label' => 'vendredi :',
                'required' => true,
                'attr' => [
                    'placeholder' => '08h45-12h00, 14h00-18h00',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner un horaire'
                    ])
                ]
            ])
            ->add('saturday', TextType::class, [
                'label' => 'samedi :',
                'required' => true,
                'attr' => [
                    'placeholder' => '08h45-12h00',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner un horaire'
                    ])
                ]
            ])
            ->add('sunday', TextType::class, [
                'label' => 'dimanche :',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Fermé',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner un horaire'
                    ])
                ]
            ])
            ->add('specialEvent', TextType::class, [
                'label' => 'Fermeture exceptionnelle :',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Ex : Fermé du 01 au 08 août 2023',
                ],
            ])
            ->add('valider', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Schedules::class,
        ]);
    }
}
