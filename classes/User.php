<?php

require_once 'Database.php';

class User
{
  private $conn;

  public function __construct()
  {
    $this->conn = Database::getInstance()->getConnection();
  }

  public function getAll(): array
  {
    try {
      $pdo = $this->conn->query("SELECT * FROM users ORDER BY id DESC");
      return $pdo->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      return ["error" => "Falha ao buscar usuarios: " . $e->getMessage()];
    }
  }

  public function getById(int $id): array|bool
  {
      try {
          $pdo = $this->conn->prepare("SELECT * FROM users WHERE id = ?");
          $pdo->execute([$id]);
          $user = $pdo->fetch(PDO::FETCH_ASSOC);
  
          if (!$user) {
              return false;
          }
  
          return $user;
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

  public function update(int $id, string $name, string $email): bool|array
  {
    try {
      $stmt = $this->conn->prepare("SELECT COUNT(*) FROM users WHERE id = ?");
      $stmt->execute([$id]);
      if ($stmt->fetchColumn() == 0) {
        return ["error" => false];
      }

      $pdo = $this->conn->prepare("UPDATE users SET name = :name, email = :email WHERE id = :id");
      $pdo->bindValue(':name', $name, PDO::PARAM_STR);
      $pdo->bindValue(':email', $email, PDO::PARAM_STR);
      $pdo->bindValue(':id', $id, PDO::PARAM_INT);
      $pdo->execute();
      
      return ["success" => true];
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
