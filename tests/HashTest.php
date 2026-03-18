<?php

use App\Utility\Hash;
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../vendor/autoload.php';

class HashTest extends TestCase
{
    // teste que generate retourne bien une chaine
    public function testGenerateRetourneUneChaine()
    {
        $result = Hash::generate("monmotdepasse");
        $this->assertIsString($result);
    }

    // teste que generateSalt retourne bien la bonne longueur
    public function testGenerateSaltLongueur()
    {
        $salt = Hash::generateSalt(32);
        $this->assertEquals(32, strlen($salt));
    }
}
