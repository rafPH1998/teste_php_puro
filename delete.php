<?php
require_once "classes/User.php";
$user = new User();
$user->delete($_GET["id"]);
header("Location: index.php");

