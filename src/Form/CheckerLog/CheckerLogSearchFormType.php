<?php

namespace App\Form\CheckerLog;

use App\Entity\Link;
use App\Form\Types\CustomDateType;
use App\Form\Types\TitleType;
use App\Repository\LinkRepository;
use App\Service\Checker\Handler\LinkCheckerRedirectCount;
use App\Service\Checker\Handler\LinkCheckerResponseCode;
use App\Service\Checker\Handler\LinkCheckerTextScraper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class CheckerLogSearchFormType extends AbstractType
{
    public function __construct(
        private TokenStorageInterface $token)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('link', EntityType::class, [
                'class' => Link::class,
                'placeholder' => 'text.choose_an_option',
                'query_builder' => function(LinkRepository $linkRepository) use ($options)
                {
                    return $linkRepository->createQueryBuilder('l')
                        ->where('l.user = :userId')
                        ->setParameter('userId', $this->token->getToken()->getUser()->getId());
                },
                'choice_label' => 'url',
                'required' => false,
            ])
            ->add('value', TitleType::class, [
                'label' => 'label.response_value',
                'required' => false,
            ])
            ->add('action', ChoiceType::class, [
                'placeholder' => 'text.choose_an_option',
                'required' => false,
                'choices' => [
                    LinkCheckerResponseCode::ACTION_NAME => LinkCheckerResponseCode::ACTION_NAME,
                    LinkCheckerRedirectCount::ACTION_NAME => LinkCheckerRedirectCount::ACTION_NAME,
                    LinkCheckerTextScraper::ACTION_NAME => LinkCheckerTextScraper::ACTION_NAME
                ],
            ])
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
            'method' => 'GET',
            'user_id' => '',
        ]);

        $resolver->setAllowedTypes('user_id', 'string');
    }
}