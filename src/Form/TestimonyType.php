<?php

namespace App\Form;

use App\Entity\Testimony;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class TestimonyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Votre nom',
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        "message" => "Veuillez renseigner votre nom et/ou prénom"
                    ])
                ]
            ])
            ->add('commentary', TextareaType::class, [
                'label' => 'Votre témoignage',
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        "message" => "Veuillez décrire votre expérience"
                    ])
                ]
            ])
            ->add('note', ChoiceType::class, [
                'label' => 'Votre note',
                'expanded' => true,
                'multiple' => false,
                'choices' => [
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                    '4' => 4,
                    '5' => 5
                ]
            ])
            ->add('valider', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Testimony::class,
        ]);
    }
}
