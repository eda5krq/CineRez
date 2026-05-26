<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/auth.php';

requireLogin();

$pageTitle = 'Profile';
$basePath = '';
$reservations = [];
$lastMovieTitle = 'No movie viewed yet';
$dbError = '';

try {
    $pdo = getPDO();

    if (!empty($_COOKIE['last_movie_id'])) {
        $movieStatement = $pdo->prepare('SELECT title FROM movies WHERE id = :id');
        $movieStatement->execute(['id' => (int) $_COOKIE['last_movie_id']]);
        $lastMovie = $movieStatement->fetch();
        if ($lastMovie) {
            $lastMovieTitle = $lastMovie['title'];
        }
    }

    $reservationStatement = $pdo->prepare(
        'SELECT r.id, r.reservation_date, r.seats, r.status, r.created_at, m.title
         FROM reservations r
         INNER JOIN movies m ON m.id = r.movie_id
         WHERE r.user_id = :user_id
         ORDER BY r.created_at DESC'
    );
    $reservationStatement->execute(['user_id' => currentUserId()]);
    $reservations = $reservationStatement->fetchAll();
} catch (Throwable $exception) {
    $dbError = $exception->getMessage();
}

include __DIR__ . '/includes/header.php';
?>

<main class="container">
    <section class="glass page-head">
        <h1>Profile</h1>
        <p>Welcome back, <?php echo e($_SESSION['user_name'] ?? 'Guest'); ?>. You can browse movies and manage reservations.</p>
    </section>

    <?php if ($dbError !== ''): ?>
        <div class="alert error"><?php echo e($dbError); ?></div>
    <?php endif; ?>

    <section class="profile-grid">
        <article class="glass">
            <h2>Account</h2>
            <p><strong>Name:</strong> <?php echo e($_SESSION['user_name'] ?? ''); ?></p>
            <p><strong>Email:</strong> <?php echo e($_SESSION['user_email'] ?? ''); ?></p>
            <p><strong>Role:</strong> <?php echo e(ucfirst($_SESSION['user_role'] ?? 'user')); ?></p>
        </article>
        <article class="glass">
            <h2>Recent Activity</h2>
            <p><strong>Last viewed movie:</strong> <?php echo e($lastMovieTitle); ?></p>
            <a class="btn btn-outline" href="movies.php">Browse more movies</a>
        </article>
    </section>

    <?php include __DIR__ . '/views/reservations/profile-table.php'; ?>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>
