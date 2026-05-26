<?php
$basePath = $basePath ?? '';
?>
<nav id="mainNav">
    <a href="<?php echo e($basePath); ?>index.php">Home</a>
    <a href="<?php echo e($basePath); ?>movies.php">Movies</a>
    <a href="<?php echo e($basePath); ?>contact.php">Contact</a>

    <?php if (isLoggedIn()): ?>
        <a href="<?php echo e($basePath); ?>booking.php">Book Ticket</a>
        <a href="<?php echo e($basePath); ?>profile.php">Profile</a>

        <?php if (isAdmin()): ?>
            <a href="<?php echo e($basePath); ?>admin/index.php">Admin</a>
        <?php endif; ?>

        <span class="nav-user">Welcome, <?php echo e($_SESSION['user_name'] ?? 'Guest'); ?></span>
        <a href="<?php echo e($basePath); ?>logout.php">Logout</a>
    <?php else: ?>
        <a href="<?php echo e($basePath); ?>login.php">Login</a>
        <a href="<?php echo e($basePath); ?>register.php">Register</a>
    <?php endif; ?>
</nav>
