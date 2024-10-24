<?php

namespace App\Controller\Achat;

use App\Entity\Achat\DemandeAchat;
use App\Form\Achat\DemandeAchatType;
use App\Repository\Achat\DemandeAchatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: ['/', '/achat/demande'])]
final class DemandeAchatController extends AbstractController
{
    #[Route(name: 'app_achat_demande_achat_index', methods: ['GET'])]
    public function index(DemandeAchatRepository $demandeAchatRepository, PaginatorInterface $paginator, Request $request): Response
    {
        return $this->render('achat/demande_achat/index.html.twig', [
            'demande_achats' => $demandeAchatRepository->paginate($paginator, $request->query->getInt("page", 1)),
        ]);
    }

    #[Route('/creation', name: 'app_achat_demande_achat_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $demandeAchat = new DemandeAchat();
        $form = $this->createForm(DemandeAchatType::class, $demandeAchat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($demandeAchat);
            $entityManager->flush();

            return $this->redirectToRoute('app_achat_demande_achat_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('achat/demande_achat/new.html.twig', [
            'demande_achat' => $demandeAchat,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_achat_demande_achat_show', methods: ['GET'])]
    public function show(DemandeAchat $demandeAchat): Response
    {
        return $this->render('achat/demande_achat/show.html.twig', [
            'demande_achat' => $demandeAchat,
        ]);
    }
}
