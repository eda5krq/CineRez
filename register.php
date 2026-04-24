<?php
// 1. Initialize variables so they exist even if the form isn't sent
$registrationSuccess = false;
$error = '';
$fullName = ''; 

// 2. ONLY run this code if the Request Method is POST (the user clicked submit)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Now these keys will exist because the form was sent!
    $fullName = $_POST['full_name'];
    $email    = $_POST['email'];
    $phone    = $_POST['phone'];
    $pass     = $_POST['password'];
    $confirm  = $_POST['confirm_password'];

    // 3. Simple Validation
    if ($pass !== $confirm) {
        $error = "Passwords do not match!";
    } else {
        // Success logic goes here
        $registrationSuccess = true;
    }
}
?>
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

    <?php if ($registrationSuccess): ?>
        <div class="alert success">
            <p><strong>Success!</strong> Account created for <?php echo htmlspecialchars($fullName); ?>.</p>
            <p><a href="login.php">Click here to login.</a></p>
        </div>
    <?php elseif ($error): ?>
        <div class="alert error">
            <p style="color: #ff4d4d;"><?php echo $error; ?></p>
        </div>
    <?php else: ?>
        <p>Register to reserve faster and track your bookings.</p>
    <?php endif; ?>

    <?php if (!$registrationSuccess): ?>
        <form method="post" action="register.php" class="stack-form">
            <button class="btn btn-primary" type="submit">Register</button>
        </form>
    <?php endif; ?>
</section>
</main>
<footer class="site-footer"><div class="container footer-inner"><p>&copy; 2026 CineRez. All rights reserved.</p><p>Frontend-only static demo version.</p></div></footer>
</body>
</html>
