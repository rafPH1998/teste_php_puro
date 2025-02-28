<?php

require_once 'Database.php';

class User
{
  private $conn;

  public function __construct()
  {
    $this->conn = Database::getInstance()->getConnection();
  }

  public function getAll()
  {
    try {
      $pdo = $this->conn->query("SELECT * FROM users ORDER BY id DESC");
      return $pdo->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      return ["error" => "Falha ao buscar usuarios: " . $e->getMessage()];
    }
  }

  public function getById(int $id)
  {
    try {
      $stmt = $this->conn->prepare("SELECT COUNT(*) FROM users WHERE id = ?");
      $stmt->execute([$id]);
      if ($stmt->fetchColumn() == 0) {
        return ["error" => "User with ID {$id} does not exist."];
      }

      $pdo = $this->conn->prepare("SELECT * FROM users WHERE id = ?");
      $pdo->execute([$id]);
      return $pdo->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      return ["error" => "Falha ao buscar usuario: " . $e->getMessage()];
    }
  }

  public function create(string $name, string $email)
  {
    try {
      $pdo = $this->conn->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
      $pdo->execute([$name, $email]);
      return ["success" => "User created successfully"];
    } catch (PDOException $e) {
      return ["error" => "Falha ao criar usuario: " . $e->getMessage()];
    }
  }

  public function update(int $id, string $name, string $email)
  {
    try {
      $stmt = $this->conn->prepare("SELECT COUNT(*) FROM users WHERE id = ?");
      $stmt->execute([$id]);
      if ($stmt->fetchColumn() == 0) {
        return ["error" => "User with ID {$id} does not exist."];
      }

      $pdo = $this->conn->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
      $pdo->execute([$name, $email, $id]);
      return ["success" => "User updated successfully"];
    } catch (PDOException $e) {
      return ["error" => "Failed to update user: " . $e->getMessage()];
    }
  }

  public function delete(int $id)
  {
    try {
      $stmt = $this->conn->prepare("SELECT COUNT(*) FROM users WHERE id = ?");
      $stmt->execute([$id]);
      if ($stmt->fetchColumn() == 0) {
        return ["error" => "User with ID {$id} does not exist."];
      }

      $pdo = $this->conn->prepare("DELETE FROM users WHERE id = ?");
      $pdo->execute([$id]);
      return ["success" => "User deleted successfully"];
    } catch (PDOException $e) {
      return ["error" => "Failed to delete user: " . $e->getMessage()];
    }
  }
}
