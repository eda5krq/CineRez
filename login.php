<?php
session_start();
include 'includes/users.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["Username"];
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | CineRez</title>
    <link rel="stylesheet" href="css/style.css">
    <noscript><style>body{opacity:1!important;transform:none!important;}</style></noscript>
    <script defer src="js/main.js"></script>
</head>
<body>
<div class="background-overlay"></div>
<header class="site-header glass">
    <div class="container nav-wrap">
        <a class="logo" href="index.php"><img src="images/cinerez-logo.svg" alt="CineRez logo"><span>CineRez</span></a>
        <button class="menu-toggle" id="menuToggle" aria-label="Toggle menu">Menu</button>
       <?php include 'nav.php'; ?>
    </div>
</header>
<main class="container">
    <section class="glass auth-card">
        <h1>Login</h1>
        <p>Use demo credentials for user or admin.</p>
        <form method="post" action="login.php" class="stack-form">
            <label>Email</label><input type="email" name="Username" required>
            <label>Password</label><input type="password" name="password" required>
            <button class="btn btn-primary" type="submit">Login</button>
        </form>
        <div class="demo-box">
            <p><strong>User:</strong> user@cinerez.com / User123</p>
            <p><strong>Admin:</strong> admin@cinerez.com / Admin123</p>
        </div>
    </section>
</main>
<footer class="site-footer"><div class="container footer-inner"><p>&copy; 2026 CineRez. All rights reserved.</p><p>Frontend-only static demo version.</p></div></footer>
</body>
</html>
