<?php
session_start();
include 'includes/users.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    foreach ($users as $user) {
        if ($user["username"] === $username && $user["password"] === $password) {

            $_SESSION["username"] = $user["username"];
            $_SESSION["role"] = $user["role"];

            header("Location: index.php");
            exit();
        }
    }

    $error = "Invalid credentials!";
}
include 'login.html';
?>