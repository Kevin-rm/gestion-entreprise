<?php
namespace App\Controller;

use App\Entity\Annexe\Produit;
use App\Service\ServiceDetailStock;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StockController extends AbstractController
{
    private EntityManagerInterface $em;
    private ServiceDetailStock $serviceDetailStock;

    public function __construct(EntityManagerInterface $em, ServiceDetailStock $serviceDetailStock)
    {
        $this->em = $em;
        $this->serviceDetailStock = $serviceDetailStock;
    }

    #[Route('/test_stock', name: 'test_stock', methods: ['GET', 'POST'])]
    public function testStock(Request $request): Response
    {
        $produits = $this->em->getRepository(Produit::class)->findAll();

        if ($request->isMethod('POST')) {
            $produitId = $request->request->get('produit_id');
            $method = $request->request->get('method');

            $produit = $this->em->getRepository(Produit::class)->find($produitId);

            $valeurStock = $this->serviceDetailStock->calculerValeurStock($produit, $method);

            return $this->render('stock_test.html.twig', [
                'produits' => $produits,
                'valeurStock' => $valeurStock,
                'method' => $method,
            ]);
        }

        return $this->render('stock_test.html.twig', [
            'produits' => $produits,
        ]);
    }
}
