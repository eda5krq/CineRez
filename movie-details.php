<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/functions.php';

$pageTitle = 'Movie Details';
$basePath = '';
$movieId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);

if (!$movieId) {
    setFlash('error', 'Please choose a valid movie.');
    redirect('movies.php');
}

try {
    $pdo = getPDO();
    $statement = $pdo->prepare('SELECT id, title, description, genre, duration, release_year, poster FROM movies WHERE id = :id');
    $statement->execute(['id' => $movieId]);
    $movie = $statement->fetch();

    if (!$movie) {
        setFlash('error', 'Movie not found.');
        redirect('movies.php');
    }
} catch (Throwable $exception) {
    setFlash('error', $exception->getMessage());
    redirect('movies.php');
}

setcookie('last_movie_id', (string) $movieId, time() + (30 * 24 * 60 * 60), '/');
$_COOKIE['last_movie_id'] = (string) $movieId;

include __DIR__ . '/includes/header.php';
include __DIR__ . '/views/movies/details.php';
include __DIR__ . '/includes/footer.php';
