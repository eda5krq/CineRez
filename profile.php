<?php
include 'includes/auth.php';
requireLogin(); // Ensure the user is logged in

// If logged in, load the profile UI:
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile | CineRez</title>
    <link rel="stylesheet" href="css/style.css">
    <noscript><style>body{opacity:1!important;transform:none!important;}</style></noscript>
    <script defer src="js/main.js"></script>
</head>
<body>
<div class="background-overlay"></div>
<header class="site-header glass">
    <div class="container nav-wrap">
        <a class="logo" href="index.php">
            <img src="images/cinerez-logo.svg" alt="CineRez logo">
            <span>CineRez</span>
        </a>
        <button class="menu-toggle" id="menuToggle" aria-label="Toggle menu">Menu</button>
        <?php include 'nav.php'; ?>
    </div>
</header>
</div>
    </div>
</header>
<main class="container">
    <section class="glass page-head">
        <h1>Profile</h1>
        <p>Welcome back, <?php echo htmlspecialchars($_SESSION["username"]); ?>. You can browse movies and reserve tickets.</p>
    </section>
    <section class="profile-grid">
        <article class="glass">
            <h2>Account</h2>
            <p><strong>Name:</strong> <?php echo htmlspecialchars($_SESSION["username"]); ?></p>
            <p><strong>Role:</strong> <?php echo htmlspecialchars(ucfirst($_SESSION["role"])); ?></p>
        </article>
        <article class="glass">
            <h2>Preferences</h2>
            <form method="post" action="#" class="stack-form" data-static-demo="true">
                <label>Preferred cinema location</label>
                <select name="preferred_location">
                    <option selected>Prishtina</option><option>Prizren</option><option>Peja</option><option>Gjilan</option>
                </select>
                <button class="btn btn-primary" type="submit">Save Preference</button>
            </form>
            <p><strong>Current:</strong> Prishtina</p>
        </article>
    </section>
    <section class="glass panel-card recent-activity-card">
        <h2>Recent Activity</h2>
        <p><strong>Last viewed movie:</strong> The Super Mario Galaxy Movie</p>
        <p>No confirmed booking yet.</p>
    </section>
</main>
<footer class="site-footer"><div class="container footer-inner"><p>&copy; 2026 CineRez. All rights reserved.</p><p>Frontend-only static demo version.</p></div></footer>
</body>
</html>
