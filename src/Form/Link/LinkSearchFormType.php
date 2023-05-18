<?php

namespace App\Form\Link;

use App\Entity\User;
use App\Form\Types\CustomDateType;
use App\Form\Types\TitleType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LinkSearchFormType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TitleType::class)
            ->add('createdAtFrom', CustomDateType::class, [
                'label' => 'label.date_from',
            ])
            ->add('createdAtTo', CustomDateType::class, [
                'label' => 'label.date_to',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'method' => 'GET'
        ]);
    }
}