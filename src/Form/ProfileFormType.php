<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class ProfileFormType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('lastName')
            ->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event)
            {
                $form = $event->getForm();

                $form->add('plainPassword', RepeatedType::class, [
                    'type' => PasswordType::class,
                    'mapped' => false,
                    'first_options' => [
                        'label' => 'label.password',
                        'attr' => [
                            'class' => 'autofill-password '
                        ]
                    ],
                    'second_options' => [
                        'label' => 'label.repeat_password',
                        'attr' => [
                            'class' => 'autofill-password '
                        ]
                    ],
                    'invalid_message' => 'Error! Passwords must match',
                    'required' => false
                ])
                    ->add('save', SubmitType::class, [
                        'label' => 'form.edit',
                        'attr' => [
                            'class' => 'btn btn-green margin--auto'
                        ]
                    ]);

            });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
