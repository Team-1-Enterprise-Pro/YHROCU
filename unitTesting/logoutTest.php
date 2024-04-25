<?php

use PHPUnit\Framework\TestCase;

require_once 'logout.php';

class LogoutTest extends TestCase
{
    public function testLogoutDestroysSession()
    {
        // Start session
        session_start();
        $_SESSION["staffNumber"] = "1234";

        // Call the logout function
        $result = logout();
        
        // Check if logout was successful
        $this->assertTrue($result);
    }

    //NOTE: ONLY TEST ONE FUNCTION AT A TIME. DELETE ONE FUNCTION, RUN THE ASSERTION AND THEN TEST THE OTHER AS SESSION VARIABLES CAN ONLY BE SET ONCE.

    public function testUnsuccessfulLogout()
    {
        // Call the logout function without starting the session
        $result = logout();

        // Check if logout was unsuccessful
        $this->assertFalse($result);
    }
}
?>
