<?php

use App\Utility\Hash;
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../vendor/autoload.php';
//test pour la classe Hash pour vérifier que la méthode generate retourne bien une chaîne de caractères qui sert a hasher les mots de passe des utilisateurs
class HashTest extends TestCase
{
    public function testGenerateRetourneUneChaine() 
    {
        $result = Hash::generate("motdepasse"); 
        $this->assertIsString($result); 
    }
}
