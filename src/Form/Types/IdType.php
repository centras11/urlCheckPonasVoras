<?php

declare(strict_types=1);

namespace App\Form\Types;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IdType extends AbstractType
{

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'label' => 'label.id',
            'required' => false,
        ]);
    }

    public function getParent(): string
    {
        return IntegerType::class;
    }
}