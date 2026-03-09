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

    // teste que deux fois le meme mdp + sel donne le meme hash
    public function testGenerateMemeMdpMemeSel()
    {
        $hash1 = Hash::generate("motdepasse", "monsalt");
        $hash2 = Hash::generate("motdepasse", "monsalt");
        $this->assertEquals($hash1, $hash2);
    }

    // teste que deux sels differents donnent des hash differents
    public function testGenerateSelDifferentHashDifferent()
    {
        $hash1 = Hash::generate("motdepasse", "salt1");
        $hash2 = Hash::generate("motdepasse", "salt2");
        $this->assertNotEquals($hash1, $hash2);
    }

    // teste que generateSalt retourne bien la bonne longueur
    public function testGenerateSaltLongueur()
    {
        $salt = Hash::generateSalt(32);
        $this->assertEquals(32, strlen($salt));
    }

    // teste que deux sels generes sont differents
    public function testGenerateSaltEstAleatoire()
    {
        $salt1 = Hash::generateSalt(32);
        $salt2 = Hash::generateSalt(32);
        $this->assertNotEquals($salt1, $salt2);
    }

    // teste que generateUnique retourne une chaine non vide
    public function testGenerateUniqueRetourneChaine()
    {
        $uid = Hash::generateUnique();
        $this->assertNotEmpty($uid);
    }
}
