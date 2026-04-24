<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | CineRez</title>
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
        <h1>Create Account</h1>
        <p>Register to reserve faster and track your bookings.</p>
        <form method="post" action="#" class="stack-form" data-static-demo="true">
            <label>Full Name</label><input type="text" name="full_name" required>
            <label>Email</label><input type="email" name="email" required>
            <label>Phone Number</label><input type="tel" name="phone" required>
            <label>Password</label><input type="password" name="password" required>
            <label>Confirm Password</label><input type="password" name="confirm_password" required>
            <button class="btn btn-primary" type="submit">Register</button>
        </form>
        <p class="small-muted">Already have an account? <a href="login.php">Login here</a>.</p>
    </section>
</main>
<footer class="site-footer"><div class="container footer-inner"><p>&copy; 2026 CineRez. All rights reserved.</p><p>Frontend-only static demo version.</p></div></footer>
</body>
</html>
