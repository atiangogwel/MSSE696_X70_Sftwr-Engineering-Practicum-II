<?php

require_once 'login.php';

use PHPUnit\Framework\TestCase;

class LoginTest extends TestCase {
    private $conn;

    protected function setUp(): void {
        // Database configuration
        $host = 'localhost';
        $username = 'root';
        $password = 'pass123';
        $database = 'LLM';
    
        // Create a connection
        $this->conn = new mysqli($host, $username, $password, $database);
    
        // Check connection
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }
    
    public function testAuthenticate(): void {
        // Check if there's a database connection
        if (!$this->conn || $this->conn->connect_error) {
            $this->markTestIncomplete('No database connection available.');
            return;
        }

        // Sample user data for testing
        $email = 'admdin@llm.com';
        $password = '123';

        // Create a new Login instance
        $login = new Login($this->conn);
        $result = $login->authenticate($email, $password);
        
        // Assertions
        $this->assertNull($result);
    }

    protected function tearDown(): void {
        // Close the database connection
        if ($this->conn) {
            $this->conn->close();
        }
    }
}
?>
