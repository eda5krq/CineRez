<?php

function requireLogin() {
    session_start();

    if (!isset($_SESSION["username"])) {
        header("Location: login.php");
        exit();
    }
}

function requireRole($role) {
    session_start();

    if (!isset($_SESSION["role"]) || $_SESSION["role"] !== $role) {
        echo "Access denied!";
        exit();
    }
}