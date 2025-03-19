<?php
session_start();
require_once "classes/User.php";
$users = (new User())->getAll();
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>CRUD Usuários</title>
    <link rel="stylesheet" href="assets/css/index.css">
</head>
<body>
    <h2>Lista de Usuários</h2>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($_SESSION['success']) ?> 
            <a href="index.php">Apagar mensagem</a>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['success-delete'])): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($_SESSION['success-delete']) ?> 
            <a href="index.php">Apagar mensagem</a>
        </div>
        <?php unset($_SESSION['success-delete']); ?>
    <?php endif; ?>
    
    <a href="create.php">Adicionar Usuário</a>
    <table>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Email</th>
            <th>Ações</th>
        </tr>
        <?php foreach ($users as $user) : ?>
            <tr>
                <td><?= $user['id'] ?></td>
                <td><?= $user['name'] ?></td>
                <td><?= $user['email'] ?></td>
                <td>
                    <a href="edit.php?id=<?= $user['id'] ?>">Editar</a>
                    <a href="delete.php?id=<?= $user['id'] ?>" onclick="return confirm('Tem certeza?')">Excluir</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
