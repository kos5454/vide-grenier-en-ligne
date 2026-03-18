<?php

use App\Utility\Hash;
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../vendor/autoload.php';

class HashTest extends TestCase
{
    public function testGenerateRetourneUneChaine() 
    {
        $result = Hash::generate("motdepasse"); 
        $this->assertIsString($result); 
    }
}
