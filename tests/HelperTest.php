<?php

namespace Tests;

use Core\Helper;
use PHPUnit\Framework\TestCase;

/**
 * HelperTest - Tests unitaires pour la classe Helper
 */
class HelperTest extends TestCase
{
    /**
     * Test 1 : Valider une adresse email correcte
     */
    public function testIsValidEmailWithCorrectEmail()
    {
        $email = 'user@example.com';
        $result = Helper::isValidEmail($email);

        $this->assertTrue($result, 'L\'email devrait être valide');
    }

    /**
     * Test 2 : Rejeter une adresse email invalide
     */
    public function testIsValidEmailWithInvalidEmail()
    {
        $email = 'invalid-email';
        $result = Helper::isValidEmail($email);

        $this->assertFalse($result, 'L\'email devrait être invalide');
    }

    /**
     * Test 3 : Formater correctement un prix
     */
    public function testFormatPrice()
    {
        $price = 45.5;
        $expected = '45,50 €';
        $result = Helper::formatPrice($price);

        $this->assertEquals($expected, $result, 'Le prix devrait être formaté correctement');
    }

    /**
     * Test 4 : Compter le nombre de mots dans une chaîne
     */
    public function testCountWords()
    {
        $text = 'Bonjour le monde';
        $expected = 3;
        $result = Helper::countWords($text);

        $this->assertEquals($expected, $result, 'Devrait compter 3 mots');
    }
}
