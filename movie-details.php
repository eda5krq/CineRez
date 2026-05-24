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

require_once __DIR__ . '/movie-details.html.php';

