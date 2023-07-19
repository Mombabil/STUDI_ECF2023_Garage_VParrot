<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Context\ExecutionContext;

class CreateEmployeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'required' => true,
                'constraints' => [
                    new Email([
                        "message" => 'L\'email "{{ value }}" n\'est pas une adresse mail valide.'
                    ])
                ]
            ])
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        "message" => "Le nom ne doit pas être vide !"
                    ])
                ]
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Prénom',
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        "message" => "Le prénom ne doit pas être vide !"
                    ])
                ]
            ])
            ->add("password", PasswordType::class, [
                "label" => "Mot de passe",
                "required" => true,
                "constraints" => [
                    new NotBlank([
                        "message" => "Le mot de passe ne peut pas être vide !"
                    ])
                ]
            ])
            ->add("confirm", PasswordType::class, [
                "label" => "Confirmer le mot de passe",
                "required" => true,
                "constraints" => [
                    new NotBlank([
                        "message" => "Le mot de passe ne peut pas être vide !"
                    ]),
                    // new EqualTo([
                    //     "propertyPath" => "password",
                    //     "message" => "Les mots de passe doivent être identique !"
                    // ])
                    new Callback([
                        'callback' => function ($value, ExecutionContext $ec) {
                            if ($ec->getRoot()['password']->getViewData() !== $value) {
                                $ec->addViolation('Les mots de passe doivent être identique !');
                            }
                        }
                    ])
                ]
            ])
            ->add('valider', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
