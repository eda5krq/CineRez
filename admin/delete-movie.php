<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/auth.php';

requireAdmin();

$pageTitle = 'Delete Movie';
$basePath = '../';

$movieId = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]])
    ?: filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);

if (!$movieId) {
    setFlash('error', 'Please choose a valid movie.');
    redirect('movies.php');
}

try {
    $pdo = getPDO();
    $statement = $pdo->prepare('SELECT id, title FROM movies WHERE id = :id');
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $delete = $pdo->prepare('DELETE FROM movies WHERE id = :id');
        $delete->execute(['id' => $movieId]);
        setFlash('success', 'Movie deleted successfully.');
    } catch (PDOException $exception) {
        if ($exception->getCode() === '23000') {
            setFlash('error', 'This movie has reservations and cannot be deleted.');
        } else {
            setFlash('error', 'Movie could not be deleted.');
            error_log('CineRez movie delete failed: ' . $exception->getMessage());
        }
    }

    redirect('movies.php');
}

include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../views/admin/delete-confirm.php';
include __DIR__ . '/../includes/footer.php';
