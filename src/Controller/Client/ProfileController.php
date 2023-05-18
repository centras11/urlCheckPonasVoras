<?php

namespace App\Controller\Client;

use App\Entity\User;
use App\Form\ProfileFormType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[Route('/profile')]
class ProfileController extends AbstractController
{

    #[Route(path: '/edit', name: 'profile_edit')]
    #[IsGranted("ROLE_USER")]
    public function edit(
        Request $request,
        EntityManagerInterface $em,
        UserPasswordHasherInterface $userPasswordHasher
    ): Response {
        $form = $this->createForm(ProfileFormType::class, $this->getUser());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            if (!empty(trim($form->get('plainPassword')->getData()))) {
                $user->setPassword($userPasswordHasher->hashPassword($user, $form->get('plainPassword')->getData()));
            }

            $this->addFlash('success', 'form.data_updated_successfully');

            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('profile_edit');
        }

        return $this->render('client/profile/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}