<?php
require_once "classes/User.php";
$userModel = new User();
$user = $userModel->getById($_GET["id"]);

if ($user === false) {
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuário</title>
</head>
<body>
    <h2>Editar Usuário</h2>
    <form action="UserController.php" method="POST">
        <input type="hidden" name="id" value="<?= $user['id'] ?>">
        <input type="text" name="name" value="<?= $user['name'] ?>" required>
        <input type="email" name="email" value="<?= $user['email'] ?>" required>
        <button type="submit" name="update">Atualizar</button>
    </form>
    <a href="index.php">Voltar</a>
</body>
</html>
