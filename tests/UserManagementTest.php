<?php

require_once 'users_process.php';

use PHPUnit\Framework\TestCase;

class UserManagementTest extends TestCase {
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
    
    public function testInsertUser(): void {
        // Check if there's a database connection
        if (!$this->conn || $this->conn->connect_error) {
            $this->markTestIncomplete('No database connection available.');
            return;
        }

        // Sample user data for testing
        $role_id = 1;
        $firstname = 'John';
        $lastname = 'Doe';
        $password = 'password123';
        $email = 'john@example.com';

        // Create a new UserManagement instance
        $userManagement = new UserManagement($this->conn);
        $result = $userManagement->insertUser($role_id, $firstname, $lastname, $password, $email);
        $this->assertTrue($result);
    }

    public function testUpdateUser(): void {
        // Check if there's a database connection
        if (!$this->conn || $this->conn->connect_error) {
            $this->markTestIncomplete('No database connection available.');
            return;
        }

        // Sample user data for testing
        $userid = 1;
        $role_id = 2;
        $firstname = 'UpdatedFirstName';
        $lastname = 'UpdatedLastName';
        $email = 'updated_email@example.com';

        // Create a new UserManagement instance
        $userManagement = new UserManagement($this->conn);
        $result = $userManagement->updateUser($userid, $role_id, $firstname, $lastname, $email);
        $this->assertTrue($result);

    }
    public function testDeleteUser(): void {
        if (!$this->conn || $this->conn->connect_error) {
            $this->markTestIncomplete('No database connection available.');
            return;
        }
    
        // Sample user ID for testing
        $deleteUserId = 1;
        $userManagement = new UserManagement($this->conn);
        $result = $userManagement->deleteUser($deleteUserId);
        $this->assertTrue($result);
        }
    

    protected function tearDown(): void {
    }
}
?>
