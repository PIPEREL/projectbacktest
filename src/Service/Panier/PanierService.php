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

    public function add(int $id)
    {

        $panier = $this->session->get("panier", []);
        $stock = $this->carteRepository->find($id)->getStock();
        if (!empty($panier[$id])) {
            if ($panier[$id] < $stock) {
                $panier[$id]++;
            } else if ($panier[$id] > $stock) {
                $panier[$id] = $stock;
            }
        } else {
            $panier[$id] = 1;
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

    public function getTotal(): float
    {
        $total = 0;

        foreach ($this->getPanier() as $article) {
            $total += $article['carte']->getPrix() * $article['quantite'];
        }
       
        if($this->session->get('livraison') == null){
            $livraison['typeLivraison'] = "untracked";
            $this->session->set('livraison', $livraison);

        }
        $test = $this->session->get('livraison');
        if ($test['typeLivraison'] == "tracked") {
            $total += 10;
        } else {
            $total += 5;
        }

        return $total;
    }
}