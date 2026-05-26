<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/auth.php';

requireAdmin();

$pageTitle = 'Admin Movies';
$basePath = '../';
$movies = [];
$dbError = '';

try {
    $pdo = getPDO();
    $statement = $pdo->query('SELECT id, title, description, genre, duration, release_year, poster FROM movies ORDER BY created_at DESC');
    $movies = $statement->fetchAll();
} catch (Throwable $exception) {
    $dbError = $exception->getMessage();
}

include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../views/admin/movie-list.php';
include __DIR__ . '/../includes/footer.php';
