<?php
require_once __DIR__ . '/classes/User.php';
require __DIR__ . '/controllers/UserController.php';

$user = new User();
$userController = new UserController($user);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = null;

    if (isset($_POST["create"])) {
        $result = $userController->create($_POST);

        if ($result === true) {
            header("Location: index.php");
            exit;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Criar Usuário</title>
    <link rel="stylesheet" href="assets/css/create.css">
</head>
<body>
    <h2>Adicionar Usuário</h2>
    
    <?php if (isset($_SESSION['errors'])): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($_SESSION['errors'] as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php unset($_SESSION['errors']); ?>
    <?php endif; ?>

    <form action="create.php" method="POST">
        <input type="text" name="name" placeholder="Nome">
        <input type="email" name="email" placeholder="Email" required>
        <button type="submit" name="create">Salvar</button>
    </form>
    <a href="index.php">Voltar</a>
</body>
</html>
