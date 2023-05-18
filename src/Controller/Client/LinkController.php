<?php

namespace App\Controller\Client;

use App\Entity\Link;
use App\Form\Link\LinkCreateFormType;
use App\Form\Link\LinkSearchFormType;
use App\Manager\Link\LinkExportManager;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/link')]
class LinkController extends AbstractController
{

    #[Route(path: '/list/{page<\d+>?1}', name: 'link_list', requirements: ['page' => '\d+'])]
    #[IsGranted("ROLE_USER")]
    public function list(
        Request $request,
        PaginatorInterface $paginator,
        EntityManagerInterface $em,
        int $page,
    ): Response {
        $form = $this->createForm(LinkSearchFormType::class, null, [
            'action' => $this->generateUrl('link_list')
        ]);

        $form->handleRequest($request);
        $filter = $form->getData();
        $records = $em->getRepository(Link::class)->findLinksByForm($filter, $this->getUser()->getId());
        $links = $paginator->paginate(
            $records,
            $request->query->getInt('page', $page),
            Link::LINK_PAGINATION
        );

        return $this->render('client/link/list.html.twig', [
            'form' => $form->createView(),
            'links' => $links,
        ]);
    }

    #[Route(path: '/edit/{link}', name: 'link_edit', requirements: ['faq' => '\d+'])]
    #[IsGranted("ROLE_USER")]
    public function edit(
        Request $request,
        Link $link,
        EntityManagerInterface $em
    ): Response {
        $form = $this->createForm(
            LinkCreateFormType::class,
            $link
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $link = $form->getData();

            $this->addFlash('success', 'success.created_successfully');

            $em->persist($link);
            $em->flush();

            return $this->redirectToRoute('link_edit', [
                'link' => $link->getId()
            ]);
        }

        return $this->render('client/link/createEdit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route(path: '/create', name: 'link_create')]
    #[IsGranted("ROLE_USER")]
    public function create(
        Request $request,
        EntityManagerInterface $em
    ): Response {
        $link = new Link();
        $form = $this->createForm(
            LinkCreateFormType::class,
            $link
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $link = $form->getData();

            $link->setUser($this->getUser());
            $this->addFlash('success', 'success.created_successfully');

            $em->persist($link);
            $em->flush();

            return $this->redirectToRoute('link_edit', [
                'link' => $link->getId()
            ]);
        }

        return $this->render('client/link/createEdit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route(path: '/delete/{link}', name: 'link_delete', requirements: ['link' => '\d+'])]
    #[IsGranted("ROLE_USER")]
    public function delete(
        Link $link,
        EntityManagerInterface $em
    ): Response {
        foreach ($link->getCheckerLogs() as $checkerLog) {
            $em->remove($checkerLog);
            $em->flush();
        }

        $em->remove($link);
        $em->flush();

        $this->addFlash('success', 'form.data_deleted_successfully');

        return $this->redirectToRoute('link_list');
    }

    #[Route(path: '/export', name: 'link_export')]
    #[IsGranted("ROLE_USER")]
    public function linkExport(
        Request $request,
        LinkExportManager $linkExportManager,
        EntityManagerInterface $em
    ): Response {
        $form = $this->createForm(LinkSearchFormType::class);
        $form->handleRequest($request);

        $filter = $form->getData();
        $links = $em->getRepository(Link::class)->findLinksByForm($filter, $this->getUser()->getId())->getResult();

        return $linkExportManager->exportXls($links);
    }

}