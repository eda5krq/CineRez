<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
    require 'includes/users.php';
} 
?>

<nav id="mainNav">
    <?php if (isset($_SESSION["email"])): ?>
<p style="color: white; margin-right: 15px;">Welcome, <?php echo htmlspecialchars($_SESSION["full_name"]); ?></p>        <a href="index.php">Home</a>
        <a href="movies.php">Movies</a>
        <a href="booking.php">Book Ticket</a>
        <a href="profile.php">Profile</a>
        
        <?php if ($_SESSION["role"] === "admin"): ?>
            <a href="admin.php">Admin Panel</a>
        <?php endif; ?>
        
        <a href="logout.php">Logout</a>

    <?php else: ?>
        <a href="index.php">Home</a>
        <a href="movies.php">Movies</a>
        <a href="login.php">Login</a>
        <a href="register.php">Register</a>
    <?php endif; ?>
</nav>