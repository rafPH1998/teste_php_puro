<?php
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
