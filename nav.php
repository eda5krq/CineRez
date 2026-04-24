<?php session_start(); ?>

<nav>

<?php if (isset($_SESSION["username"])): ?>

    <p>Welcome, <?php echo $_SESSION["username"]; ?></p>

    <a href="index.php">Home</a>
    <a href="movies.php">Movies</a>

    <?php if ($_SESSION["role"] === "admin"): ?>
        <a href="admin.php">Admin Panel</a>
    <?php endif; ?>

    <a href="booking.php">Book Ticket</a>
    <a href="logout.php">Logout</a>

<?php else: ?>

    <a href="login.php">Login</a>

<?php endif; ?>

</nav>