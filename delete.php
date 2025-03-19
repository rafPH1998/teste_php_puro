<?php
require_once "classes/User.php";
require __DIR__ . '/controllers/UserController.php';

$user = new User();
$userController = new UserController($user);
$result = $userController->delete($_GET["id"]);

if ($result === true) {
    header("Location: index.php");
    exit;
}

