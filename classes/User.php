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
    $pdo = $this->conn->query("SELECT * FROM users ORDER BY id DESC");
    return $pdo->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getById($id)
  {
    $pdo = $this->conn->prepare("SELECT * FROM users WHERE id = ?");
    $pdo->execute([$id]);
    return $pdo->fetch(PDO::FETCH_ASSOC);
  }

  public function create($name, $email)
  {
    $pdo = $this->conn->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
    return $pdo->execute([$name, $email]);
  }

  public function update($id, $name, $email)
  {
    $pdo = $this->conn->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
    return $pdo->execute([$name, $email, $id]);
  }

  public function delete($id)
  {
    $pdo = $this->conn->prepare("DELETE FROM users WHERE id = ?");
    return $pdo->execute([$id]);
  }
}
