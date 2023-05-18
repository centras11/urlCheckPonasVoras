<?php

namespace App\Form\Link;

use App\Form\Types\CustomDateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;

class LinkCreateFormType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'label.link_title',
            ])
            ->add('scrapeText', TextType::class, [
                'label' => 'label.scrape_text',
            ])
            ->add('url', UrlType::class, [
                'label' => 'label.link_url',
            ])
            ->add('save', SubmitType::class, [
                'label' => 'form.edit',
                'attr' => [
                    'class' => 'btn btn-green margin--auto'
                ]
            ]);;
    }
}