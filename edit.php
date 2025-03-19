<?php
require_once "classes/User.php";
require_once "controllers/UserController.php";

$userModel = new User();
$userController = new UserController($userModel);

// Verifica se o ID foi passado e busca o usuário
if (!isset($_GET["id"])) {
    header("Location: index.php");
    exit;
}

$user = $userModel->getById($_GET["id"]);
// Verifica se o ID existe na base
if ($user === false) {
    header("Location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["update"])) {
    $result = $userController->update($_POST);

    if ($result === true) {
        header("Location: index.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuário</title>
    <link rel="stylesheet" href="assets/css/edit.css">
</head>
<body>
    <h2>Editar Usuário</h2>

    <form action="edit.php?id=<?= $user['id'] ?>" method="POST">
        <input type="hidden" name="id" value="<?= $user['id'] ?>">
        <input type="text" name="name" value="<?= $user['name'] ?>">
        <input type="email" name="email" value="<?= $user['email'] ?>">
        <button type="submit" name="update">Atualizar</button>
    </form>
    <a href="index.php">Voltar</a>
</body>
</html>
