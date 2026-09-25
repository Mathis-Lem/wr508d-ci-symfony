<?php

namespace App\Service;

use App\Entity\Product;

final class InventoryService
{
    /** @var array<int, int> */
    private array $stock = [];

    /**
     * @param list<Product> $products
     */
    public function __construct(array $products = [])
    {
        foreach ($products as $product) {
            $this->stock[$product->getId()] = $product->getStock();
        }
    }

    public function sell(Product $product, int $quantity): void
    {
        if ($quantity < 0) {
            throw new \InvalidArgumentException('La quantité ne peut pas être négative.');
        }

        $id = $product->getId();
        $currentStock = $this->stockOf($product);

        if ($currentStock < $quantity) {
            throw new \InvalidArgumentException('Le stock est insuffisant pour cette vente.');
        }

        $this->stock[$id] -= $quantity;
    }

    public function restock(Product $product, int $quantity): void
    {
        if ($quantity < 0) {
            throw new \InvalidArgumentException('La quantité ne peut pas être négative.');
        }

        // Initialise la clé si le produit n'était pas dans le tableau d'origine
        if (!isset($this->stock[$product->getId()])) {
            $this->stock[$product->getId()] = 0;
        }

        $this->stock[$product->getId()] += $quantity;
    }

    public function stockOf(Product $product): int
    {
        return $this->stock[$product->getId()] ?? 0;
    }
}
