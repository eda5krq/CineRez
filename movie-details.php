<?php
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/data.php';

$movieId = (int) ($_GET['id'] ?? 1);
$movie = getMovieById($movies, $movieId);

if (!$movie) {
    header('Location: movies.php');
    exit();
}

setcookie('last_movie_id', (string)$movieId, time() + (30 * 24 * 60 * 60), '/');
$_COOKIE['last_movie_id'] = (string)$movieId;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Details | CineRez</title>
    <link rel="stylesheet" href="css/style.css">
    <noscript>
        <style>
            body {
                opacity: 1 !important;
                transform: none !important;
            }
        </style>
    </noscript>
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
        <section class="movie-details glass">
            <div class="details-poster poster-placeholder large">
                <img
                    src="images/<?php echo sanitizeInput($movie['poster']); ?>"
                    alt="<?php echo sanitizeInput($movie['title']); ?> poster">
            </div>

            <div class="details-content">
                <h1><?php echo sanitizeInput($movie['title']); ?></h1>

                <p class="small-muted">
                    <?php echo sanitizeInput($movie['title']); ?>
                    (<?php echo sanitizeInput($movie['genre']); ?>) -
                    <?php echo (int)$movie['duration']; ?> min,
                    Rating: <?php echo sanitizeInput($movie['rating']); ?>
                </p>

                <p><?php echo sanitizeInput($movie['description']); ?></p>

                <p><strong>Genre:</strong> <?php echo sanitizeInput($movie['genre']); ?></p>
                <p><strong>Duration:</strong> <?php echo (int)$movie['duration']; ?> min</p>
                <p><strong>Rating:</strong> <?php echo sanitizeInput($movie['rating']); ?> / 10</p>
                <p><strong>Age Rating:</strong> <?php echo sanitizeInput($movie['age_rating']); ?></p>
                <p><strong>Director:</strong> <?php echo sanitizeInput($movie['director']); ?></p>
                <p><strong>Release Date:</strong> <?php echo sanitizeInput($movie['release_date']); ?></p>
                <p><strong>Price:</strong> <?php echo formatPrice($movie['price']); ?></p>
                <p><strong>Cast:</strong> <?php echo sanitizeInput(implode(', ', $movie['cast'])); ?></p>

                <div class="showtimes">
                    <h3>Showtimes</h3>
                    <?php foreach ($movie['showtimes'] as $time): ?>
                        <span><?php echo sanitizeInput($time); ?></span>
                    <?php endforeach; ?>
                </div>

                <a class="btn btn-primary" href="booking.php?movie_id=<?php echo (int)$movie['id']; ?>">
                    Reserve Tickets
                </a>
            </div>
        </section>
    </main>
    <footer class="site-footer">
        <div class="container footer-inner">
            <p>&copy; 2026 CineRez. All rights reserved.</p>
            <p>Frontend-only static demo version.</p>
        </div>
    </footer>
</body>

</html>