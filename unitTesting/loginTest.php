<?php

use PHPUnit\Framework\TestCase;
require_once 'login.php';
class loginTest extends TestCase
{
    public function testCheckLoggedIn()
    {
        // Simulate a logged-in session
        $session = ["staffNumber" => "123"];

        // Call the function with the simulated session
        $loggedIn = checkLoggedIn($session);

        // Assert that the function returns true when logged in
        $this->assertTrue($loggedIn);
    }

    public function testCheckNotLoggedIn()
    {
        // Simulate a logged-in session
        $session = [];

        // Call the function with the simulated session
        $loggedIn = checkLoggedIn($session);

        // Assert that the function returns true when logged in
        $this->assertFalse($loggedIn);
    }
}

