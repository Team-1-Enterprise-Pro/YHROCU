<?php

use PHPUnit\Framework\TestCase;
require_once 'connect.php';

class connectTest extends TestCase
{
    public function testDatabaseConnection()
    {
        // Call the connectToDatabase function
        $connTest = connectToDatabase();

        // Check if a valid connection object is returned
        $this->assertTrue($connTest);

    }

}
