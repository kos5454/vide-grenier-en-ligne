<?php

namespace Core;

/**
 * Helper - Classe utilitaire simple
 */
class Helper
{
    /**
     * Valide si une adresse email est valide
     *
     * @param string $email
     * @return bool
     */
    public static function isValidEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * Formate un prix avec 2 décimales
     *
     * @param float $price
     * @return string
     */
    public static function formatPrice($price)
    {
        return number_format($price, 2, ',', ' ') . ' €';
    }

    /**
     * Vérifie si une chaîne est vide
     *
     * @param string $str
     * @return bool
     */
    public static function isEmpty($str)
    {
        return empty(trim($str));
    }

    /**
     * Compte le nombre de mots dans une chaîne
     *
     * @param string $str
     * @return int
     */
    public static function countWords($str)
    {
        return str_word_count($str);
    }
}
