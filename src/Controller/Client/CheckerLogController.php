<?php

namespace App\Controller\Client;

use App\Entity\Checker\CheckerLog;
use App\Entity\Link;
use App\Form\CheckerLog\CheckerLogSearchFormType;
use App\Manager\Checker\CheckerLogExportManager;
use App\Service\Checker\CheckerHandler;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/checker-log')]
class CheckerLogController extends AbstractController
{

    #[Route(path: '/list/{page<\d+>?1}', name: 'checker_log_list', requirements: ['page' => '\d+'])]
    #[IsGranted("ROLE_USER")]
    public function list(
        Request $request,
        PaginatorInterface $paginator,
        EntityManagerInterface $em,
        int $page,
    ): Response {
        $form = $this->createForm(CheckerLogSearchFormType::class, null, [
            'action' => $this->generateUrl('checker_log_list'),
        ]);

        $form->handleRequest($request);
        $filter = $form->getData();
        $records = $em->getRepository(CheckerLog::class)->findCheckerLogsByForm($filter, $this->getUser()->getId());
        $checkerLogs = $paginator->paginate(
            $records,
            $request->query->getInt('page', $page),
            CheckerLog::LINK_PAGINATION
        );

        return $this->render('client/checker-log/list.html.twig', [
            'form' => $form->createView(),
            'checkerLogs' => $checkerLogs,
        ]);
    }

    #[Route(path: '/export', name: 'checker_log_export')]
    #[IsGranted("ROLE_USER")]
    public function checkerLogExport(
        Request $request,
        CheckerLogExportManager $checkerLogExportManager,
        EntityManagerInterface $em
    ): Response {
        $form = $this->createForm(CheckerLogSearchFormType::class);
        $form->handleRequest($request);

        $filter = $form->getData();
        $links = $em->getRepository(CheckerLog::class)->findCheckerLogsByForm($filter,$this->getUser()->getId())->getResult();

        return $checkerLogExportManager->exportXls($links);
    }

    #[Route(path: '/run-check', name: 'checker_log_run')]
    #[IsGranted("ROLE_USER")]
    public function runCheck(
        CheckerHandler $checkerHandler,
        EntityManagerInterface $em
    ): Response {
        $items = $em->getRepository(Link::class)->findLinksByForm([],$this->getUser()->getId())->getResult();

        foreach ($items as $link) {
            $checkerHandler->checkLink($link);
        }

        return new RedirectResponse($this->generateUrl('checker_log_list'));
    }

}