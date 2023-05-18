<?php

declare(strict_types=1);

namespace App\Form\Types;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TitleType extends AbstractType
{

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'label' => 'label.link_title',
            'required' => false,
        ]);
    }

    public function getParent(): string
    {
        return TextType::class;
    }
}