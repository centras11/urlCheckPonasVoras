<?php

declare(strict_types=1);

namespace App\Form\Types;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CustomDateType extends AbstractType
{

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'label' => 'label.date',
            'required' => false,
            'widget' => 'single_text',
            'html5' => true,
            'label_attr' => [
                'class' => 'form-label',
            ],
            'attr' => [
                'class' => 'js-datepicker ',
                'autocomplete' => 'off',
            ],
        ]);
    }

    public function getParent(): string
    {
        return DateType::class;
    }
}