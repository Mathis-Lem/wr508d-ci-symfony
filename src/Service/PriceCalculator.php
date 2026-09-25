<?php

namespace App\Service;

final class PriceCalculator
{
    public function discountRate(float $subtotal, bool $isVip): float
    {
        $discount = 0.0;

        if ($subtotal > 100.0) {
            $discount += 0.10;
        }

        if ($isVip) {
            $discount += 0.10;
        }

        return min($discount, 0.20);
    }

    /**
     * @return array{float, float, float}
     */
    public function calculate(float $subtotal, bool $isVip): array
    {
        $discount = $this->discountRate($subtotal, $isVip);

        // Les frais de port sont de 5.0 en dessous de 50 d'achats
        $shipping = $subtotal >= 50.0 ? 0.0 : 5.0;

        // Le total est le sous-total moins la remise, auquel on ajoute les frais de port
        $total = $subtotal - ($subtotal * $discount) + $shipping;

        return [$total, $discount, $shipping];
    }
}
