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
    public function testIsValidEmailWithCorrectEmail() //fonction de test pour valider une adresse email correcte
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
        $email = 'invalid-email'; //regarde si l'email est invalide
        $result = Helper::isValidEmail($email); //resultat de la validation de l'email

        $this->assertFalse($result, 'L\'email devrait être invalide'); //envoie
    }

    /**
     * Test 3 : Tester si une chaîne vide
     */
    public function testIsEmptyWithEmptyString()
    {
        $text = '   ';
        $result = Helper::isEmpty($text);

        $this->assertTrue($result, 'La chaîne vide devrait retourner true');
    }

    /**
     * Test 4 : Tester si une chaîne est non vide
     */
    public function testIsEmptyWithNonEmptyString()
    {
        $text = 'hello';
        $result = Helper::isEmpty($text);

        $this->assertFalse($result, 'La chaîne non vide devrait retourner false');
    }
}
