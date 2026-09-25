<?php

namespace App\Service;

final class InputSanitizer
{
    public function escape(string $input): string
    {
        // Convertit les caractères spéciaux (comme < et >) en entités HTML
        return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
    }

    public function isStrongPassword(string $password): bool
    {
        // Vérifie une longueur minimale de 8 caractères
        if (strlen($password) < 8) {
            return false;
        }

        // Vérifie la présence d'au moins une minuscule, une majuscule et un chiffre
        $containsLowercase = preg_match('/[a-z]/', $password);
        $containsUppercase = preg_match('/[A-Z]/', $password);
        $containsNumber = preg_match('/\d/', $password);

        return (bool) ($containsLowercase && $containsUppercase && $containsNumber);
    }

    /**
     * @return non-empty-string
     */
    public function sanitizeProductName(string $rawName): string
    {
        $clean = trim(strip_tags($rawName));

        if ('' === $clean) {
            throw new \InvalidArgumentException('Le nom du produit ne peut pas être vide.');
        }

        return $clean;
    }
}
