<?php

namespace App\Service\Panier;

use App\Repository\CarteRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class PanierService
{

    protected $session;
    protected $carteRepository;

    public function __construct(SessionInterface $session, CarteRepository $carteRepository)

    {
        $this->session = $session;
        $this->carteRepository = $carteRepository;
    }

    public function livraison($data)
    {
        $livraison = $this->session->get("livraison", []);
        $livraison['typeLivraison'] = $data['typeLivraison'];
        $this->session->set('livraison', $livraison);
    }

    public function add(int $id, int $quantity=1)
    {
        $panier = $this->session->get("panier", []);
        $stock = $this->carteRepository->find($id)->getStock();
        if (!empty($panier[$id])) {
            if ($panier[$id] < $stock) {
            $panier[$id]+= $quantity;
            } else if ($panier[$id] > $stock) {
                $panier[$id] = $stock;
            }
        } else {
            $panier[$id] = $quantity;
        }
        $this->session->set('panier', $panier);
    }

    public function minus(int $id)
    {
        $panier = $this->session->get("panier", []);
        $stock = $this->carteRepository->find($id)->getStock();
        $panier[$id]--;
        if ($panier[$id] <= 0) {
            unset($panier[$id]);
        }else if($panier[$id] > $stock){
            $panier[$id] = $stock;
        }
        $this->session->set('panier', $panier);
    }

    public function delete(int $id)
    {
        $panier = $this->session->get("panier", []);

        if (!empty($panier[$id])) {
            unset($panier[$id]);
        }
        $this->session->set('panier', $panier);
    }

    public function getPanier(): array
    {
        $panier = $this->session->get('panier', []);

        $panierWithData = [];

        foreach ($panier as $id => $quantite) {
            $panierWithData[] = [
                'carte' => $this->carteRepository->find($id),
                'quantite' => $quantite
            ];
        }

        return $panierWithData;
    }

    public function getTotal(): array
    {
        $total = 0;
        $totalLivraison = 0;

        foreach ($this->getPanier() as $article) {
            $total += $article['carte']->getPrix() * $article['quantite'];
        }
       
        if($this->session->get('livraison') == null){
            $livraison['typeLivraison'] = "untracked";
            $this->session->set('livraison', $livraison);

        }
        $test = $this->session->get('livraison');
        if ($test['typeLivraison'] == "tracked") {
            $totalLivraison = $total +10;
        } else {
            $totalLivraison = $total + 5;
        }
        
        $totals["total"] = $total;
        $totals["totalLivraison"] = $totalLivraison;
        return $totals;
    }

    public function getQteTotal(): int
    {
        $qte = 0;
        foreach ($this->getPanier() as $article) {
            $qte += $article['quantite'];
        }
        return $qte;

    }


}