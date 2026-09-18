<?php

namespace App\Service;

final class InputSanitizer
{
    public function escape(string $input): string
    {
        return $input;
    }

    public function isStrongPassword(string $password): bool
    {
        return '' !== $password;
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
